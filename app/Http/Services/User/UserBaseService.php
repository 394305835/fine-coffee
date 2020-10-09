<?php

namespace App\Http\Services\User;

use App\Model\Mysql\UserModel;

/**
 * 该类提供了用户模块的基本方法
 */
class UserBaseService
{
    /**
     * 检查权限,检查两个集合中是否存在包含或相同
     *
     * @param array $owner 小集合
     * @param array $compare 大集合
     * @param string $relation 如果为 'or' 表示满足任一条规则即通过验证;如果为 'and'则表示需满足所有规则才能通过验证
     * @return boolean
     */
    public function check(array $owner = [], array $compare = [], string $relation = 'and'): bool
    {
        if (!$owner || !$compare) {
            return false;
        }
        // 如果包含root权限
        // if ($this->hasRootRule($compare)) {
        //     return true;
        // }

        // 求比较的两个交集
        // 利用 array_intersect_key 对 key 的比较
        $intersect = array_intersect_key(array_flip($owner), array_flip($compare));
        $intersect = array_keys($intersect);
        if ('and' === $relation) {
            // 全部满足才行,差集为空才OK
            return empty(array_diff($owner, $intersect));
        }

        // 有一个满足就，交集为空就OK
        if ('or' === $relation && !empty($intersect)) {
            return true;
        }

        return false;
    }
}
