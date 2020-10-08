<?php

namespace App\Http\Controllers\Api\V1\Admin;

use App\Contracts\RestFul\RESTFulAPI;
use App\Contracts\RestFul\Ret\RetInterface;
use App\Http\Controllers\Controller;
use App\Http\Requests\AuthAdminIndexRequest;
use App\Http\Requests\AuthAdminLogIndexRequest;
use App\Http\Requests\AuthAdminLoginRequest;
use App\Http\Requests\AuthAdminSaveRequest;
use App\Http\Requests\IDsRequest;
use App\Http\Services\AuthService\AdminService;
use App\Http\Services\AuthService\LoginService;
use Illuminate\Http\Request;

class AuthAdminController extends Controller
{
    /**
     * 当前登录管理员个人信息
     *
     * @api
     * @param Request $request
     * @return PsrResponseInterface
     */
    public function getUserInfo(Request $request, AdminService $service)
    {
        return $this->api->reply($service->getUserInfo($request));
    }

    /**
     * 管理员登录
     *
     * @param AuthAdminLoginRequest $request
     * @param LoginService $service
     * @return PsrResponseInterface
     */
    public function login(AuthAdminLoginRequest $request, LoginService $service)
    {
        return $this->api->reply($service->login($request));
    }

    /**
     * 管理员登出
     *
     * @param AuthAdminLoginRequest $request
     * @param LoginService $service
     * @return PsrResponseInterface
     */
    public function logout(AuthAdminLoginRequest $request, LoginService $service)
    {
        return $this->api->reply($service->logout($request));
    }

    /**
     * 管理员-列表
     *
     * @param AuthAdminIndexRequest $request
     * @param AdminService $service
     * @return PsrResponseInterface
     */
    public function index(AuthAdminIndexRequest $request, AdminService $service)
    {
        return $this->api->reply($service->getAdminList($request));
    }

    /**
     * 管理员管理-管理员-新增/编辑
     *
     * @param AuthAdminSaveRequest $request
     * @param AdminService $service
     * @return PsrResponseInterface
     */
    public function saveAdmin(AuthAdminSaveRequest $request, AdminService $service)
    {
        return $this->api->reply($service->saveAdmin($request));
    }

    /**
     * 管理员管理-管理员-删除
     *
     * @param IDsRequest $request
     * @param AdminService $service
     * @return PsrResponseInterface
     */
    public function deleteAdmin(IDsRequest $request, AdminService $service)
    {
        return $this->api->reply($service->deleteAdmin($request));
    }

    /**
     * 管理员日志管理-获取
     *
     * @param AuthAdminLogIndexRequest $request
     * @param AdminService $service
     * @return PsrResponseInterface
     */
    public function getAdminLogs(AuthAdminLogIndexRequest $request, AdminService $service)
    {
        return $service->getAdminLogs($request);
    }
}
