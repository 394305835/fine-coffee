<?php

namespace App\Lib\Parameter;

/**
 * 条件参数组装，包括条件查询，模糊查询，in查询
 */
class WhereParam extends RequestParam
{

    /**
     * 比较规则表
     *
     * @var array
     */
    protected $compare = [];

    /**
     * 模糊查询的规则表
     *
     * @var array
     */
    protected $like = [];

    /**
     * in 条件的规则表
     *
     * @var array
     */
    protected $in = [];

    /**
     * 初始的参数,如果这里面没，则会尝试去请求中取参数.
     *
     * @var array
     */
    protected $params = [
        'compare' => [],
        'in' => [],
        'like' => [],
    ];


    /**
     * 通用初始参数设置方法
     *
     * @param string $op
     * @param string $key
     * @param mixed $value
     * @return self
     */
    protected function setParams(string $op = 'compare', string $key, $value): self
    {
        if (isset($this->params[$op])) {
            $this->params[$op][$key] = $value;
        }
        return $this;
    }

    /**
     * 构建 where 条件查询
     *
     * @return array[0] $where
     * @return array[1] $in
     */
    public function build(): array
    {
        $where = array_merge($this->buildCompare(), $this->buildLike());
        $in = $this->buildIn();
        return [$where, $in];
    }

    /**
     * 比较规则初始参数设置
     *
     * @param string $key
     * @param mixed $value
     * @return self
     */
    public function setCompareParam(string $key, $value): self
    {
        return $this->setParams('compare', $key, $value);
    }

    /**
     * 模糊规则初始参数设置
     *
     * @param string $key
     * @param mixed $value
     * @return self
     */
    public function setLikeParam(string $key, $value): self
    {
        return $this->setParams('like', $key, $value);
    }

    /**
     * in条件规则初始参数设置
     *
     * @param string $key
     * @param mixed $value
     * @return self
     */
    public function setInParam(string $key, $value): self
    {
        return $this->setParams('in', $key, $value);
    }


    public function buildCompare(): array
    {
        $where = [];
        // 构建比较条件
        foreach ($this->compare as $fed => $op) {
            if (!$value = $this->parseParam($fed, $this->params['compare'])) {
                continue;
            }
            $where[] = [$fed, $op, $value];
        }
        return $where;
    }

    public function buildLike(): array
    {
        $where = [];
        // 构建糊糊条件
        foreach ($this->like as $fed => $op) {
            if (!$value = $this->parseParam($fed, $this->params['like'])) {
                continue;
            }
            switch ($op) {
                case '%%':
                    $where[] = [$fed, 'like', "%${value}%"];
                    break;
                case '_%':
                    $where[] = [$fed, 'like', "${value}%"];
                    break;
                case '%':
                case '%_':
                    $where[] = [$fed, 'like', "%${value}"];
                    break;
            }
        }
        return $where;
    }

    /**
     * Undocumented function
     *
     * @param array $values 可以是数组也可以是 ,分隔的字符串
     * @return array
     */
    public function buildIn(): array
    {
        $in = [];
        // 构建in条件
        foreach ($this->in as $fed => $op) {
            if (!$value = $this->parseParam($fed, $this->params['in'])) {
                continue;
            }
            if (!is_array($value)) {
                $value = explode(',', $value);
            }
            $in[] = [$fed, $op, $value];
        }
        return $in;
    }

    /**
     * 验证比较型字段
     *
     * @param string $rule eg. :=,:>=,:<>,:<,:<=,:
     * @return boolean
     */
    public function checkCompareRule(string $rule): bool
    {
        return !!preg_match('/^[a-zA-Z]+(\:{0,1}(=|==|>|>=|<|<=|<>){0,1})$/', $rule);
    }

    /**
     * 验证模糊型字段
     *
     * @param string $rule eg. :%%,:_%,:%_,:
     * @return boolean
     */
    public function checkLikeRule(string $rule): bool
    {
        return !!preg_match('/^[a-zA-Z]+(\:{0,1}(\%|\%\_|\_\%|\%\%){0,1})$/', $rule);
    }

    /**
     * 验证 in 型字段
     *
     * @param string $rule eg. :not,:in,:
     * @return boolean
     */
    public function checkInRule(string $rule): bool
    {
        return !!preg_match('/^[a-zA-Z]+(\:{0,1}(not|in){0,1})$/', $rule);
    }


    /**
     * 比较规则设置 getter/setter.
     * 当前参数 $rules 为空时为获取
     *
     * @param array<string> ...$rules
     * @return array|self
     */
    public function compare(...$rules)
    {
        if (!empty($rules)) {
            foreach ($rules as $_rule) {
                if ($this->checkCompareRule((string) $_rule)) {
                    $rule = explode(':', $_rule);
                    $this->compare[array_shift($rule)] = $rule ? array_shift($rule) : '=';
                }
            }
            return $this;
        }
        return $this->compare;
    }

    /**
     * 模糊规则设置 getter/setter.
     * 当前参数 $rules 为空时为获取
     *
     * @param array<string> ...$rules
     * @return array|self
     */
    public function like(...$rules)
    {
        if (!empty($rules)) {
            foreach ($rules as $_rule) {
                if ($this->checkLikeRule((string) $_rule)) {
                    $rule = explode(':', $_rule);
                    $this->like[array_shift($rule)] = $rule ? array_shift($rule) : '%%';
                }
            }
            return $this;
        }
        return $this->like;
    }

    /**
     * In条件规则设置 getter/setter.
     * 当前参数 $rules 为空时为获取
     *
     * @param array<string> ...$rules
     * @return array|self
     */
    public function in(...$rules)
    {
        if (!empty($rules)) {
            foreach ($rules as $_rule) {
                if ($this->checkInRule((string) $_rule)) {
                    $rule = explode(':', $_rule);
                    $this->in[array_shift($rule)] = $rule ? array_shift($rule) : 'in';
                }
            }
            return $this;
        }
        return $this->in;
    }
}
