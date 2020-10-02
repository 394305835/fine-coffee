<?php

namespace App\Http\Services;

use App\Lib\Tree;
use App\Repositories\AuthAccess;
use App\Repositories\AuthGroup;

/**
 * 
 */

class AuthService extends AuthBaseService
{
    /**
     * 获取用户所在组
     * ps:Admin->group
     */
    public function getUserGroup($uids)
    {
        return  $this->getGroups($uids);
    }

    /**
     * 获取用户的访问规则
     * ps: Admin->rule
     */
    public function getUserRules($uids)
    {
        $groupIds = $this->getGroups($uids);
        return  $this->getRules($groupIds);
    }

    /**
     * 获取用户的所有下属组
     */
    public function getUserSubGroup($uid, $self = false)
    {
        $userGroupId = $this->getGroupAccessGroupIds([$uid]);
        $allGroup = AuthGroup::singleton('id', 'pid', 'name', 'rules', 'rules_default')->all();
        $allGroup = json_decode(json_encode($allGroup), true);
        // TODO:目前只处理一个用户一个角色情况，暂不考虑一个用户多个角色情况
        $groupId = $userGroupId[0];
        $ids = Tree::instance()->getChildren($allGroup, $groupId, $self);
        return $ids;
    }

    /**
     * 获取用户下级所有组的ID
     */
    public function getSubGroupIds($uid)
    {
        //获取$uid下面的所有组
        $subGroup = $this->getUserSubGroup($uid);
        //UID下级所有的groupId
        return array_column($subGroup, 'id');
    }

    /**
     * 获取组的用户
     */
    public function getGroupUserIds($groupIds)
    {
        //UID下面的所有用户关系
        $access = AuthAccess::singleton('uid', 'group_id')->getAccessByGroup($groupIds);
        //UID下面的所有UID
        return array_column($access, 'uid');
    }

    /**
     * 判断$subUids用户是否归属$uid管
     */
    public function hasUser($uid, $subUids)
    {
        $groupIds = $this->getSubGroupIds($uid);
        $subAllUids = $this->getGroupUserIds($groupIds);
        return $this->check($subUids, $subAllUids);
    }
}
