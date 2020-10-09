<?php

namespace App\Http\Controllers\Api\V1\User;

use App\Http\Controllers\Controller;
use App\Http\Requests\User\UserIndexRequest;
use App\Http\Requests\User\UserSaveRequest;
use App\Http\Services\User\YhService;

class UserController extends Controller
{

    /**
     * 用户-列表
     *
     * @param UserIndexRequest $request
     * @param UserService $service
     * @return PsrResponseInterface
     */
    public function index(UserIndexRequest $request, YhService $service)
    {
        return $this->api->reply($service->getUserList($request));
    }

    /**
     * 用户管理-用户-新增
     *
     * @param UserSaveRequest $request
     * @param YhService $service
     * @return PsrResponseInterface
     */
    public function saveUser(UserSaveRequest $request, YhService $service)
    {
        return $this->api->reply($service->saveUser($request));
    }
}
