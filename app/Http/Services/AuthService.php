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
        return   $this->getGroups($uids);
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
    public function getUserSubGroup($uid, $self = false, $child = false)
    {
        $userGroupId = $this->getGroupAccessGroupIds([$uid]);
        // TODO:目前只处理一个用户一个角色情况，暂不考虑一个用户多个角色情况
        $groupId = $userGroupId[0];

        $allGroup = $this->getAllGroup();
        $ids = Tree::instance()->getChildren($allGroup, $groupId, $self, $child);
        return $ids;
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
     * 获取下级用户
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
     * 判断subGroupIds组的ID是否属于UID所在的用户管
     */
    public function hasUserGroup($uid, $subGroupIds, $self = false)
    {
        $GroupIds = $this->getSubGroupIds($uid, $self);
        return $this->check($subGroupIds, $GroupIds);
    }

    /**
     * 判断指定组下面是否有用户
     */
    public function hasGroupUser($groupIds)
    {
        $uids = $this->getGroupAccessUIds($groupIds);
        return !empty($uids);
    }
}
