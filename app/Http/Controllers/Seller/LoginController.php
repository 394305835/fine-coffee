<?php

namespace App\Http\Controllers\Seller;

use App\Http\Controllers\Controller;
use App\Http\Requests\Seller\SellerLoginRequest;
use App\Http\Services\Seller\LoginService;

class LoginController extends Controller
{
    /**
     * 商家登录
     *
     * @param AuthAdminLoginRequest $request
     * @param LoginService $service
     * @return PsrResponseInterface
     */
    public function login(SellerLoginRequest $request, LoginService $service)
    {
        return $this->api->reply($service->login($request));
    }

    /**
     * 商家登出
     *
     * @param AuthAdminLoginRequest $request
     * @param LoginService $service
     * @return PsrResponseInterface
     */
    public function logout(LoginService $service)
    {
        return $this->api->reply($service->logout($this->request));
    }
}
