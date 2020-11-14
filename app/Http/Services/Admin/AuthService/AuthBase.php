<?php

namespace App\Http\Services\Admin\AuthService;

use App\Model\Mysql\AuthGroupAccessModel;
use App\Model\Mysql\AuthGroupModel;
use App\Model\Mysql\AuthRuleModel;
use App\Repositories\AuthGroup;

trait Check
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

/**
 * 该类提供后台鉴权相关服务.
 * 1. 用户
 * 2. 角色
 * 3. 访问权限 
 */
class AuthBase
{
    use Check;

    /**
     * 获取用户对应的组信息,可以接受多个用户的组信息
     * 提供UID，找到关系表ACCESS，找到UID对应的Group_id，查询group表，拿到信息。OVER！
     * ps: Admin->group
     */
    public function getGroups(array $uids)
    {
        //
        static $_groups = [];
        //表示把$uids交给你，查询这几个用户对应的组ID
        $groupIds = $this->getGroupAccessGroupIds($uids);
        $groups = AuthGroupModel::select('id', 'pid', 'name', 'rules', 'rules_default')
            ->whereIn('id', $groupIds)->get();
        return $groups;

        /**
         * PS:分析---获取用户的组信息，那么我们需要查找出来的字段就是用户组信息里面的一些字段.
         * 这里为'id', 'pid', 'name', 'rules', 'rules_default'，我们需要传入用户的UID，在auth_group_access
         *  中去查找UID对应的group_ID，然后拿到组group_ID去group表中查找我们需要的字段
         */
    }

    /**
     * 获取Access的基本方法.最终得到UID和group_id的对应关系(也就是把满足条件的access表中的数据查出来)--桥梁
     */
    protected function getGroupAccessByKey(array $ids, $key = 'uid'): array
    {
        return AuthGroupAccessModel::whereIn($key, $ids)->get()->toArray();

        /**
         * PS:分析--获取用户所对应的组ID，我们只需要拿到组的ID就行，需要查询的标是auth_group_access组中的
         * UID与group_id的对应关系，这里传入UID，然后去单表查询，ID对应的group_id就行了
         */
    }

    /**
     * 获取用户所对应的组ID
     * ps: Admin->Access
     * 用用户ID获取对应的group_id
     */
    public function getGroupAccessGroupIds(array $uids): array
    {
        return array_column($this->getGroupAccessByKey($uids), 'group_id');

        /**
         * PS:分析--获取用户所对应的组ID，我们只需要拿到组的ID就行，需要查询的标是auth_group_access组中的
         * UID与group_id的对应关系，这里传入UID，然后去单表查询，ID对应的group_id就行了
         */
    }

    /**
     * 获取用户所对应的组的UID
     * ps: Admin->Acces
     * 用用户ID获取对应的UID
     */
    public function getGroupAccessUIds(array $groupIds): array
    {
        return array_column($this->getGroupAccessByKey($groupIds, 'group_id'), 'uid');

        /**
         * PS:分析--获取用户所对应的组ID，我们只需要拿到组的ID就行，需要查询的标是auth_group_access组中的
         * UID与group_id的对应关系，这里传入UID，然后去单表查询，ID对应的group_id就行了
         */
    }

    /**
     * 获取组信息对应的规则列表信息
     * ps: group->rule
     */
    public function getRules(array $groupIds, array $where = [], $field = []): array
    {
        $rulesId = $this->getRuleIdsByGroup($groupIds);
        if (empty($field)) {
            $field = ['id', 'pid', 'type', 'path', 'title', 'meta', 'status', 'sort'];
        }

        $rules = AuthRuleModel::select($field);

        // TIP#1 超管权限
        if (!in_array('*', $rulesId)) {
            $rules = $rules->whereIn('id', $rulesId);
        }

        if (!empty($where)) {
            $rules = $rules->where($where);
        }
        return $rules->get()->toArray();

        /**
         * 获取组信息对应的规则列表，规则列表的ID号在group组中的rule字段。
         * 传入组的ID，然后去查询组表中的字段，最好打印一下看看查出来的是什么，然后看下怎么处理，
         * 因为对应的规则不止一个数据，可能是多个，合并数组，放在一起。然后拿到这个对应的组的规则的ID了
         * 就去rule表中查询具体的规则。whereIn()方法
         * 
         */
    }

    /**
     * 获取组信息对应的规则列表ID
     * ps: group->ruleid
     */
    public function getRuleIdsByGroup(array $groupIds)
    {
        $groups = AuthGroupModel::whereIn('id', $groupIds)->pluck('rules');
        $temp = [];
        foreach ($groups as $_rules) {
            //把两个数组合并成一个数组 用0=>?,1=>?,2=>?表示
            $temp = array_merge($temp, explode(',', $_rules));
        }
        // TODO:这里去除重复的规则ID（一人多个角色，可能存在多个）
        return $temp;

        /**
         * 获取组信息对应的规则列表，规则列表的ID号在group组中的rule字段。
         * 传入组的ID，然后去查询组表中的字段，最好打印一下看看查出来的是什么，然后看下怎么处理，
         * 因为对应的规则不止一个数据，可能是多个，合并数组，放在一起。然后拿到这个对应的组的规则的ID了
         */
    }


    /**
     * 获取所有组信息
     */
    public function getAllGroup(array $field = []): array
    {
        if (empty($field)) {
            $allGroup = AuthGroup::singleton('id', 'pid', 'name', 'rules', 'rules_default')->all();
        } else {
            // ...表示把里面元素分别取出来
            $allGroup = AuthGroup::singleton(...$field)->all();
        }
        return $allGroup->toArray();
    }
}
