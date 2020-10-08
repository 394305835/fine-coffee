<?php

namespace App\Http\Controllers\Api\V1\Admin;

use App\Contracts\RestFul\Ret\RetInterface;
use App\Http\Controllers\Controller;
use App\Http\Requests\AuthRuleIndexRequest;
use App\Http\Requests\AuthRuleSaveRequest;
use App\Http\Requests\IDsRequest;
use App\Http\Services\Admin\AuthService\RuleService;

class AuthRuleController extends Controller
{
    /**
     * 权限管理-菜单规则-列表获取
     *
     * @param RuleService $service
     * @return PsrResponseInterface
     */
    public function apiIndex(AuthRuleIndexRequest $request, RuleService $service)
    {
        return $this->api->reply($service->getRuleList($request));
    }

    /**
     * 权限管理-菜单规则-列表获取
     *
     * @param RuleService $service
     * @return PsrResponseInterface
     */
    public function index(AuthRuleIndexRequest $request, RuleService $service)
    {
        return $this->api->reply($service->getRuleList($request, true));
    }

    /**
     * 权限管理-菜单规则-下拉列表
     *
     * @api
     * @param AuthRuleIndexRequest $request
     * @param RuleService $service
     * @return PsrResponseInterface
     */
    public function getSelect(AuthRuleIndexRequest $request, RuleService $service)
    {
        return $this->api->reply($service->getSelect($request));
    }

    /**
     * 权限管理-菜单规则-保存或添加
     *
     * @param AuthRuleSaveRequest $request
     * @param RuleService $service
     * @return PsrResponseInterface
     */
    public function saveRule(AuthRuleSaveRequest $request, RuleService $service)
    {
        return $this->api->reply($service->saveRule($request));
    }

    public function changeRuleStatus(IDsRequest $request, RuleService $service)
    {
        return $this->api->reply($service->changeRuleStatus($request));
    }

    /**
     * 权限管理-菜单规则-删除
     *
     * @param IDsRequest $request
     * @param RuleService $service
     * @return PsrResponseInterface
     */
    public function deleteRule(IDsRequest $request, RuleService $service)
    {
        return $this->api->reply($service->deleteRule($request));
    }
}
