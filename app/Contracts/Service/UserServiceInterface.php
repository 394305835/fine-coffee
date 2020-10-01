<?php

namespace App\Contracts\Service;

use App\Contracts\RestFul\Ret\RetInterface;
use App\Contracts\Service\Access\EntityServiceInterface;
use App\Contracts\Service\Access\LoginServiceInterface;
use App\Http\Requests\CipherRequest;
use Illuminate\Http\Request;

interface UserServiceInterface extends EntityServiceInterface, LoginServiceInterface
{
    /**
     * 获取一个用户信息
     *
     * @param Request $request
     * @return RetInterface
     */
    public function getUser(Request $request): RetInterface;

    /**
     * 保存用户的解密密文.
     *
     * 该密文是用户自己为了查看添加密码本密码的密文而用，类似密码盐
     * 
     * @param CipherRequest $request
     * @return RetInterface
     */
    public function saveUserCipher(CipherRequest $request): RetInterface;
}
