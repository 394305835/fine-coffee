<?php

namespace App\Http\Services;

use App\Model\Mysql\AuthGroupAccessModel;
use App\Model\Mysql\AuthGroupModel;
use App\Model\Mysql\AuthRuleModel;

/**
 * 该类提供后台鉴权相关服务.
 * 1. 用户
 * 2. 角色
 * 3. 访问权限 
 */

class AuthBaseService
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

    /**
     * 获取用户对应的组信息
     * ps: Admin->group
     */
    public function getGroups($uids)
    {
        //表示把$uids交给你，查询这几个用户对应的组ID
        $groupIds = $this->getGroupAccessGroupIds($uids);
        $groups = AuthGroupModel::select('id', 'pid', 'name', 'rules', 'rules_default')
            ->whereIn('id', $groupIds)->get();
        return $groups;
    }


    /**
     * 获取用户所对应的组ID
     * ps: Admin->Access
     */
    public function getGroupAccessGroupIds($uids)
    {
        return AuthGroupAccessModel::whereIn('uid', $uids)->pluck('group_id');
    }

    /**
     * 获取组信息对应的规则列表
     * ps: group->rule
     */
    public function getRules($groupIds)
    {
        $rulesId = $this->getRuleIdsByGroup($groupIds);
        return AuthRuleModel::select('id', 'pid', 'type', 'path', 'title', 'icon')
            ->whereIn('id', $rulesId)->get();
    }

    /**
     * 获取组信息对应的规则列表ID
     * ps: group->ruleid
     */
    public function getRuleIdsByGroup($groupId)
    {
        $groups = AuthGroupModel::whereIn('id', $groupId)->pluck('rules');
        $temp = [];
        foreach ($groups as $_rules) {
            $temp = array_merge($temp, $_rules);
        }
        return $temp;
    }

    /**
     * 
     * ps: admin -> sub admin
     */

}
