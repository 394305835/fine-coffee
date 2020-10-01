<?php

namespace App\Lib;

class Tree
{
    protected static $instance;

    /**
     * 初始化
     * @access public
     * @return Tree
     */
    public static function instance()
    {
        if (is_null(self::$instance)) {
            self::$instance = new static();
        }
        return self::$instance;
    }

    /**
     * 将一个数组转换成型
     *
     * @param array $items
     * @param integer $maxLevel
     * @return array
     */
    public static function create(array $items, int $maxLevel = 10): array
    {
        $minId = (int) max(min(array_column($items, 'pid')), 0);
        return self::instance()->getChildren($items, $minId, true, true, 1, $maxLevel);
    }

    /**
     * 无限组分类树，查找关系为 id和pid
     * @param array $item 分类数据
     * @param integer [$myid] 需查找的最高级ID, 默认起始为 0
     * @param boolean [$withself] 是否包含自身
     * @param boolean [$toChild] 是否将追加到 child 中，如果需要变成树形则 myid 起始必须为 0
     * @param boolean [$level]  初始层级
     * @param boolean [$maxLevel]  最大层级
     * @return array
     */
    public function getChildren(array $items, int $myid = 0, bool $withself = false, bool $toChild = false, int $level = 1, int $maxLevel = 10): array
    {
        $result = [];
        foreach ($items as $item) {
            // !!! 防止自己遍历自己(死循环)
            if (empty($item['id']) || $item['pid'] == $item['id']) {
                continue;
            }
            if ($item['pid'] == $myid) {
                // !!! 只需要第一次时包含自己后面则不需要
                $child = $this->getChildren($items, $item['id'], false, $toChild, $level + 1, $maxLevel);
                if ($level < $maxLevel && $toChild) {
                    $item['child'] = $child;
                } else {
                    $result = array_merge($result, $child);
                }
                $result[] = $item;
            } elseif ($withself && $item['id'] == $myid) {
                $result[] = $item;
            }
        }
        return $result;
    }

    /**
     * 得到当前位置所有父辈数组
     * @param int
     * @param bool $withself 是否包含自己
     * @return array
     */
    public function getParents($items, $myid, $withself = false)
    {
        $pid = 0;
        $newarr = [];
        foreach ($items as $value) {
            if (!isset($value['id'])) {
                continue;
            }
            if ($value['id'] == $myid) {
                if ($withself) {
                    $newarr[] = $value;
                }
                $pid = $value['pid'];
                break;
            }
        }
        if ($pid) {
            $arr = $this->getParents($items, $pid, true);
            $newarr = array_merge($arr, $newarr);
        }
        return $newarr;
    }
}
