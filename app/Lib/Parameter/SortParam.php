<?php

namespace App\Lib\Parameter;

/**
 * 排序参数组装
 */
class SortParam extends RequestParam
{
    /**
     * 排序字段规则表
     *
     * @var array
     */
    protected $sort = [];

    public function __construct(string $key = "", $value = 'ASC')
    {
        parent::__construct();
        $this->sort($key, $value);
    }

    /**
     * 构建 where 条件查询
     *
     * @return array[0] $where
     * @return array[1] $in
     * @return array[2] $sort
     */
    public function build(): array
    {
        return $this->buildSort();
    }

    /**
     * 构建 sort 字段
     * 
     * ```
     * sort: id,time
     * sortBy: 0,1 || asc,desc
     * ```
     *
     * @param array $values
     * @return array
     */
    public function buildSort(): array
    {
        $result = [];
        if (!empty($this->sort)) {
            // 构建sort条件
            $resort = $this->parseParam('sort');
            if (!is_array($resort)) {
                $resort = explode(',', $resort);
            }
            $sort = [];
            foreach ($resort as $_sort) {
                if (isset($this->sort[$_sort])) {
                    $sort[] = $_sort;
                }
            }
            $sortBy = $this->parseParam('sortBy');
            if (!is_array($sortBy)) {
                $sortBy = explode(',', $sortBy);
            }
            foreach ($sort as $idn => $_sort) {
                $result[$_sort] = isset($sortBy[$idn])
                    ? $this->toSortBy($sortBy[$idn])
                    : $this->sort[$_sort];
            }
        }
        return $result;
    }


    /**
     * 排序规则设置 getter/setter.
     * 
     * $key 和 $value 都不空时获取所有 sort
     * 
     * $key 存在时,$value 不存在获取指定key
     * 
     * $key 和 $value 同时存在则为设置值.
     *
     * @param string $key
     * @param string $value
     * @return mixed|self
     */
    public function sort(string $key = "", $value = 'ASC')
    {
        if (empty($key)) {
            return $this->sort;
        }
        if (!empty($key)) {
            if (is_null($value)) {
                return isset($this->sort[$key]) ? $this->sort[$key] : null;
            }
            $this->sort[$key] = $this->toSortBy($value);
        }
        return $this;
    }

    /**
     *  否是排序方式
     *
     * @param mixed $value 可以是任意数字,和大小写 asc/ASC 和 desc/DESC
     * @return string asc/ASC 和 desc/DESC
     */
    public function toSortBy($value)
    {
        if (!is_numeric($value)) {
            $value = strtoupper($value);
            $value = 'ASC' === $value || 'DESC' === $value ? $value : 'ASC';
        } else {
            $value = $value ? 'DESC' : 'ASC';
        }
        return $value;
    }
}
