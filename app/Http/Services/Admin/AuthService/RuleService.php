<?php


namespace App\Http\Services\Admin\AuthService;

use App\Contracts\RestFul\Ret\RetInterface;
use App\Http\Requests\AuthRuleSaveRequest;
use App\Http\Services\Admin\AuthService;
use App\Lib\RetJson;
use App\Lib\Tree;
use App\Repositories\AuthRule;
use Illuminate\Http\Request;

class RuleService extends Auth
{
    /**
     * 权限管理-菜单规则-列表获取
     *
     * @param Request $request
     * @return RetInterface
     */
    public function getRuleList(Request $request): RetInterface
    {
        $rules = $this->getUserRules(REQUEST_UID, [], ['id', 'pid', 'title']);
        return RetJson::pure()->list($rules);
    }

    /**
     * 权限管理-菜单规则-下拉列表
     *
     * @param Request $request
     * @return RetInterface
     */
    public function getSelect(Request $request, string $type = ''): RetInterface
    {
        $where = [];
        if ($type == AuthRule::TYPE_API || $type == AuthRule::TYPE_ROUTER) {
            $where[] = ['type', '=', $type];
        }
        $rules = $this->getUserRules(REQUEST_UID, $where, ['id', 'pid', 'title']);
        $rules = Tree::create($rules);
        return RetJson::pure()->list($rules);
    }

    /**
     * 权限管理-菜单规则-添加
     *
     * @param Request $request
     * @return RetInterface
     */
    public function saveRule(AuthRuleSaveRequest $request): RetInterface
    {
        $ruleId = $request->input('pid', 0);
        $post = $request->only(array_keys($request->rules()));
        // //不指定父ID就增加，如果指定父ID就判断自己是否有权限。
        // if ($this->hasRules(REQUEST_UID, [$ruleId])) {
        //     if (!empty(AuthRule::singleton()->getRuleByPath($post['path']))) {
        //         return RetJson::pure()->error('规则已经存在');
        //     }
        //     AuthRule::singleton()->insert($post);
        //     return RetJson::pure()->msg('添加成功');
        // }
        // return RetJson::pure()->error('无权限');

        if (empty($ruleId)) {
            //增加判断是否是超级管理员
            if ($this->isSuperAdmin(REQUEST_UID)) {
                $post['pid'] = 0;
                $rule = AuthRule::singleton()->getRuleByPath($post['path']);
                if (empty($rule)) {
                    AuthRule::singleton()->insert($post);
                    return RetJson::pure()->msg('添加成功');
                } else {
                    return RetJson::pure()->error('规则已经存在');
                }
            } else {
                return RetJson::pure()->error('无权限');
            }
        } else {
            if ($this->hasRules(REQUEST_UID, [$ruleId])) {
                $rule = AuthRule::singleton()->getRuleByPath($post['path']);
                if (empty($rule)) {

                    AuthRule::singleton()->insert($post);
                    return RetJson::pure()->msg('添加成功');
                } else {
                    return RetJson::pure()->error('规则已经存在');
                }
            } else {
                return RetJson::pure()->error('无权限');
            }
        }
    }

    /**
     * 权限管理-菜单规则-删除,支持多个
     * Admin.id------ruleID
     *
     * @param Request $request
     * @return RetInterface
     */
    public function deleteRule(Request $request): RetInterface
    {
        $ruleIds = $request->input('ids');
        if ($this->hasRules(REQUEST_UID, $ruleIds)) {
            AuthRule::singleton()->deleteByIds($ruleIds);
            return RetJson::pure()->msg('删除成功');
        } else {
            return RetJson::pure()->error('无权限');
        }
    }

    /**
     * 权限管理-菜单规则-状态改变,支持多个
     *
     * @param Request $request
     * @return RetInterface
     */
    public function changeRuleStatus(Request $request)
    {
    }
}
