<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Http\Requests\User\UserLoginRequest;
use App\Http\Services\User\LoginService;

class LoginController extends Controller
{
    /**
     * 用户登录
     *
     * @param AuthAdminLoginRequest $request
     * @param LoginService $service
     * @return PsrResponseInterface
     */
    public function login(UserLoginRequest $request, LoginService $service)
    {
        return $this->api->reply($service->login($request));
    }

    /**
     * 用户登出
     *
     * @param AuthAdminLoginRequest $request
     * @param LoginService $service
     * @return PsrResponseInterface
     */
    // public function logout($request, LoginService $service)
    // {
    //     return $this->api->reply($service->logout($request));
    // }
}
