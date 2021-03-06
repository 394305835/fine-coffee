<?php

namespace App\Http\Services\Admin\AuthService;

use App\Lib\Tree;
use App\Repositories\AuthAccess;
use App\Repositories\AuthRule;

/**
 * 
 */

class Auth extends AuthBase
{
    /**
     * 获取用户组信息
     * ps:Admin->group
     * 在access表中看当前UID用户属于哪个group_id组，然后看这个组有什么访问规则再查询出来。
     * 这
     */
    public function getUserGroup($uid)
    {
        return $this->getGroups([$uid]);
    }

    /**
     * 获取用户的访问规则
     * ps: Admin->rule
     * Admin.uid->access.group_id.  group_id->rules(value)->rule.id
     */
    public function getUserRules(int $uid, array $params = [], array $field = [])
    {
        $groupIds = $this->getGroupAccessGroupIds([$uid]);
        return $this->getRules($groupIds, $params, $field);
    }

    /**
     * 获取用户的所有下属组
     */
    public function getUserSubGroup($uid, $self = false, $child = false, $field = [])
    {
        // 1--获取用户所有组的ID
        $userGroupIds = $this->getGroupAccessGroupIds([$uid]);
        // 2--循环遍历所有组ID，取的每一个组下面的下属组
        $allGroup = $this->getAllGroup($field);
        $result = [];
        foreach ($userGroupIds as $_groupId) {
            $subGroups = Tree::factory()->getChildren($allGroup, $_groupId, $self, $child);
            // FIXME:生成树形结构需要修改后面，这里就是手动组合数据
            if ($child && !empty($subGroups[1])) {
                $temp = array_shift($subGroups);
                $temp['child'] = $subGroups;
                $subGroups = $temp;
            }
            $result = array_merge($result, $subGroups);
        }
        return $result;
    }

    /**
     * 获取用户下级所有组的ID
     */
    public function getSubGroupIds($uid, $self = false)
    {
        //获取$uid下面的所有组
        $subGroup = $this->getUserSubGroup($uid, $self);
        //UID下级所有的groupId
        return array_column($subGroup, 'id');
    }

    /**
     * 获取组的用户
     */
    public function getGroupUserIds($groupIds)
    {
        //UID下面的所有用户关系
        $access = AuthAccess::singleton('uid', 'group_id')->getAccessByGroup($groupIds)->toarray();
        //UID下面的所有UID
        return array_column($access, 'uid');
    }

    /**
     * 获取下级用户ID
     * PS:获取Admin->Admin
     * Admin->Access->Group->ACCESS->Admin
     * 
     */
    public function getSubUserIds($uid)
    {
        $groupIds = $this->getSubGroupIds($uid);
        return $this->getGroupUserIds($groupIds);
    }

    /**
     * 判断$subUids用户是否归属$uid管
     */
    public function hasUser($uid, $subUids)
    {
        $subAllUids = $this->getSubUserIds($uid);
        return $this->check($subUids, $subAllUids);
    }

    /**
     * 判断下级组的ID是否属于UID所在的用户管(判断是否有下级组,$self这个参数是表示是否包括自己)
     */
    public function hasUserGroup($uid, $subGroupIds, $self = false)
    {
        $GroupIds = $this->getSubGroupIds($uid, $self);
        return $this->check($subGroupIds, $GroupIds);
    }

    /**
     * 用uid获取用户所有规则ID
     * Admin.id->group.rules
     */
    public function getUserRuleIds($uid)
    {
        $groupIds = $this->getGroupAccessGroupIds([$uid]);
        $rulesIds = $this->getRuleIdsByGroup($groupIds);
        return $rulesIds;
    }

    /**
     * 判断指定组下面是否有用户
     */
    public function hasGroupUser($groupIds)
    {
        $uids = $this->getGroupAccessUIds($groupIds);
        return !empty($uids);
    }

    /**
     * 判断用户是否有某些权限
     * 
     * @param int $uid
     * @param array<int> $subRulesIds 规则ID
     */
    public function hasRules(int $uid, array $subRulesIds): bool
    {
        $rulesIds = $this->getUserRuleIds($uid);

        return in_array('*', $rulesIds) || $this->check($subRulesIds, $rulesIds);
    }


    /**
     * 判断用户是否属于超级管理员 可以获取这个用户的所有group.rules
     */
    public function isSuperAdmin($uid)
    {
        $ruleIds = $this->getUserRuleIds($uid);
        return in_array('*', $ruleIds);
    }

    /**
     * 验证用户是否有某个访问地址的权限
     *
     * @param integer $uid
     * @param string $path
     * @return boolean
     */
    public function hasRuleByPath(int $uid, string $path): bool
    {
        $where = [['type', '=', AuthRule::TYPE_API]];
        $rules = $this->getUserRules($uid, $where);
        $rules = array_column($rules, null, 'path');
        return !empty($rules[$path]);
    }
}
