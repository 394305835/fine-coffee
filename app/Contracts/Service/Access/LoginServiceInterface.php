<?php

namespace App\Contracts\Service\Access;

use App\Contracts\RestFul\Ret\RetInterface;
use Illuminate\Http\Request;


/**
 * 登录 与 注册的通用接口.
 * 
 * 根据查资料登录 和 注册分别用 log in 和 sign up 两个短语
 * 
 * @see https://www.zhihu.com/question/20330840
 */
interface LoginServiceInterface
{
    /**
     * 登录
     *
     * @param Request $request
     * @return RetInterface
     */
    public function login(Request $request): RetInterface;

    /**
     * 登出
     *
     * @param Request $request
     * @return RetInterface
     */
    public function logout(Request $request): RetInterface;

    /**
     * 注册
     *
     * @param Request $request
     * @return RetInterface
     */
    public function signup(Request $request): RetInterface;
}
