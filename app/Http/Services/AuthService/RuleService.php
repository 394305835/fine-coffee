<?php


namespace App\Http\Services\AuthService;

use Illuminate\Http\Request;

class RuleService
{
    /**
     * 权限管理-菜单规则-列表获取
     *
     * @param Request $request
     * @return PsrResponseInterface
     */
    public function getRuleList(Request $request, bool $hasHanlder = false)
    {
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
     *
     * @param Request $request
     * @return PsrResponseInterface
     */
    public function deleteRule(Request $request)
    {
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
