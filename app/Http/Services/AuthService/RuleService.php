<?php


namespace App\Http\Services\AuthService;

use App\Http\Services\AuthService;
use App\Lib\RetJson;
use Illuminate\Http\Request;

class RuleService extends AuthService
{
    /**
     * 权限管理-菜单规则-列表获取
     *
     * @param Request $request
     * @return PsrResponseInterface
     */
    public function getRuleList(Request $request, bool $hasHanlder = false)
    {
        $current = 2;
        $rules = $this->getUserRules($current);
        return RetJson::pure()->list($rules);
    }

    /**
     * 权限管理-菜单规则-下拉列表
     *
     * @param Request $request
     * @return PsrResponseInterface
     */
    public function getSelect(Request $request)
    {
    }

    /**
     * 权限管理-菜单规则-保存或添加
     *
     * @param Request $request
     * @return PsrResponseInterface
     */
    public function saveRule(Request $request)
    {
    }

    /**
     * 权限管理-菜单规则-删除,支持多个
     * Admin.id------ruleID
     *
     * @param Request $request
     * @return PsrResponseInterface
     */
    public function deleteRule(Request $request)
    {
        $currentUid = 2;
        $ruleIds = $request->input('ids');
        if ($this->hasRules($currentUid, $ruleIds)) {
            echo '删除成功';
        } else {
            echo '无权限';
        }
    }

    /**
     * 权限管理-菜单规则-状态改变,支持多个
     *
     * @param Request $request
     * @return PsrResponseInterface
     */
    public function changeRuleStatus(Request $request)
    {
    }
}
