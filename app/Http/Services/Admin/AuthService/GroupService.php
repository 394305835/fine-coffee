<?php


namespace App\Http\Services\Admin\AuthService;

use App\Contracts\RestFul\Ret\RetInterface;
use App\Http\Requests\AuthGroupSaveRequest;
use App\Lib\RetJson;
use App\Repositories\AuthGroup;
use Illuminate\Http\Request;

class GroupService extends Auth
{
    /**
     * 权限管理-角色组-列表获取
     *
     * @param Request $request
     * @return RetInterface
     */
    public function getRoleList(Request $request, bool $hasHandler = false): RetInterface
    {
        /**
         * 1--Admin->group 拿到当前登录用户的UID，在access表中查找对应的uid和group_id的关系
         * 然后在group表中找到group_)id对应的角色 
         */
        //获取用户所有的下数组,包括自己
        $agroups = $this->getUserSubGroup(REQUEST_UID, true);
        return RetJson::pure()->list($agroups);
    }

    /**
     * 权限管理-角色组-下拉列表
     *
     * @param Request $request
     * @return RetInterface
     */
    public function getSelect(Request $request): RetInterface
    {
        /**
         * 1--Admin->group 拿到当前登录用户的UID，在access表中查找对应的uid和group_id的关系
         * 然后在group表中找到group_)id对应的角色 
         */
        //获取用户所有的下数组,包括自己
        $agroups = $this->getUserSubGroup(REQUEST_UID, true, true, ['id', 'pid', 'name']);
        return RetJson::pure()->list($agroups);
    }

    /**
     * 权限管理-角色组-保存或添加
     *
     * @param Request $request
     * @return RetInterface
     */
    public function saveGroup(AuthGroupSaveRequest $request): RetInterface
    {
        $post = $request->only(array_keys($request->rules()));
        unset($post['rules']['*']);
        if ($this->hasUserGroup(REQUEST_UID, [$post['pid']], true)) {
            // !!! 这一步非常关键
            $ruleIds = $post['rules'];
            if ($this->hasRules(REQUEST_UID, $ruleIds)) {
                try {
                    $post['rules'] = implode(',', $post['rules']);
                    $post['rules_default'] = implode(',', $post['rules_default']);
                    AuthGroup::singleton()->insert($post);
                    return RetJson::pure()->msg('保存成功');
                } catch (\Throwable $th) {
                    return RetJson::pure()->throwable($th);
                }
            } else {
                return RetJson::pure()->error('规则不匹配，无权限操作');
            }
        } else {
            return RetJson::pure()->error('无权限');
        }
    }

    /**
     * 权限管理-角色组-删除,支持多个
     *
     * @param Request $request
     * @return RetInterface
     */
    public function deleteGroup(Request $request): RetInterface
    {
        /**
         * 1--验证组是否存在或者所属当前登录用户的。
         * 2--判断这个组下面是否有用户。只能删除下级中没有人的角色。
         * 删除这个职位要么是没得人的，要么是下级没得人的 同时满足这两种情况
         */
        $subGroupIds = $request->input('ids');
        if ($this->hasUserGroup(REQUEST_UID, $subGroupIds)) {
            if ($this->hasGroupUser($subGroupIds)) {
                return RetJson::pure()->error('当前职位存在人员，无法删除');
            } else {
                AuthGroup::singleton()->deleteGroupByIds($subGroupIds);
                return RetJson::pure()->msg('删除成功');
            }
        } else {
            return RetJson::pure()->error('无权限');
        }
    }
}
