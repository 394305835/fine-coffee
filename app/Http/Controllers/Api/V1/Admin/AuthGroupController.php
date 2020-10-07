<?php

namespace App\Http\Controllers\Api\V1\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\AuthGroupIndexRequest;
use App\Http\Requests\AuthGroupSaveRequest;
use App\Http\Requests\IDsRequest;
use App\Http\Services\AuthService\GroupService;

class AuthGroupController extends Controller
{
    /**
     * 角色组-列表
     *
     * @param AuthGroupIndexRequest $request
     * @param GroupService $service
     * @return PsrResponseInterface
     */
    public function index(AuthGroupIndexRequest $request, GroupService $service)
    {
        return $this->api->reply($service->getRoleList($request, true));
    }

    /**
     * 角色组-下拉菜单
     *
     * @api
     * @param AuthGroupIndexRequest $request
     * @param GroupService $service
     * @return PsrResponseInterface
     */
    public function getSelect(AuthGroupIndexRequest $request, GroupService $service)
    {
        return $this->api->reply($service->getSelect($request));
    }

    /**
     * 角色组-新增/编辑
     *
     * @param AuthGroupSaveRequest $request
     * @param GroupService $service
     * @return PsrResponseInterface
     */
    public function saveGroup(AuthGroupSaveRequest $request, GroupService $service)
    {
        return $this->api->reply($service->saveGroup($request));
    }

    /**
     * 角色组-删除
     *
     * @param IDsRequest $request
     * @param GroupService $service
     * @return PsrResponseInterface
     */
    public function deleteGroup(IDsRequest $request, GroupService $service)
    {
        return $this->api->reply($service->deleteGroup($request));
    }
}
