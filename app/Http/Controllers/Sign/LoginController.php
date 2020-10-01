<?php

namespace App\Http\Controllers\Sign;

use App\Http\Controllers\Controller;
use App\Http\Requests\UserLoginRequest;
use App\Http\Requests\UserSignupRequest;
use App\Http\Services\UserService;

class LoginController extends Controller
{
    public function login(UserLoginRequest $req, UserService $svc)
    {
        return $this->api->reply($svc->login($req));
    }

    public function signup(UserSignupRequest $req, UserService $svc)
    {
        return $this->api->reply($svc->signup($req));
    }

    public function logout(UserService $svc)
    {
        return $this->api->reply($svc->logout($this->request));
    }
}
