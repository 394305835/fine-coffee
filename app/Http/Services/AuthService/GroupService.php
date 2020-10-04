<?php


namespace App\Http\Services\AuthService;

use App\Http\Services\AuthService;
use App\Lib\RetJson;
use App\Lib\Tree;
use Illuminate\Http\Request;

class GroupService extends AuthService
{
    /**
     * 权限管理-角色组-列表获取
     *
     * @param Request $request
     * @return PsrResponseInterface
     */
    public function getRoleList(Request $request, bool $hasHandler = false)
    {
        /**
         * 1--Admin->group 拿到当前登录用户的UID，在access表中查找对应的uid和group_id的关系
         * 然后在group表中找到group_)id对应的角色 
         */
        $currentuid = 2;
        //获取用户所有的下数组,包括自己
        $agroups = $this->getUserSubGroup($currentuid, true);
        return RetJson::pure()->list($agroups);
    }

    /**
     * 权限管理-角色组-下拉列表
     *
     * @param Request $request
     * @return PsrResponseInterface
     */
    public function getSelect(Request $request)
    {
        /**
         * 1--Admin->group 拿到当前登录用户的UID，在access表中查找对应的uid和group_id的关系
         * 然后在group表中找到group_)id对应的角色 
         */
        $currentuid = 2;
        //获取用户所有的下数组,包括自己
        $agroups = $this->getUserSubGroup($currentuid, true, true);
        // dd($agroups);
        // @TODO 处理树状结构
        // $agroups = Tree::create($agroups);
        // dd($agroups);
        // return RetJson::pure()->list($agroups);
    }

    /**
     * 权限管理-角色组-保存或添加
     *
     * @param Request $request
     * @return PsrResponseInterface
     */
    public function saveGroup(Request $request)
    {
        /**
         * 1--
         */
        $currentuid = 2;
        $post = $request->only(array_keys($request->rules()));
        if ($this->hasUserGroup($currentuid, [$post['group_id']], true)) {
            // !!! 这一步非常关键
            $ruleIds = $post['rules'];
            if ($this->hasRules($currentuid, $ruleIds)) {
                echo '入库成功';
            } else {
                echo '规则不匹配，无权限操作';
            }
        } else {
            echo '无权限';
        }
    }

    /**
     * 权限管理-角色组-删除,支持多个
     *
     * @param Request $request
     * @return PsrResponseInterface
     */
    public function deleteGroup(Request $request)
    {
        /**
         * 1--验证组是否存在或者所属当前登录用户的。
         * 2--判断这个组下面是否有用户。只能删除下级中没有人的角色。
         * 删除这个职位要么是没得人的，要么是下级没得人的 同时满足这两种情况
         */
        $currentuid = 2;
        $subGroupIds = $request->input('ids');
        if ($this->hasUserGroup($currentuid, $subGroupIds)) {
            if ($this->hasGroupUser($subGroupIds)) {
                echo '当前职位存在人员，无法删除';
            } else {
                echo '删除成功';
            }
        } else {
            echo '无权限';
        }
    }
}
