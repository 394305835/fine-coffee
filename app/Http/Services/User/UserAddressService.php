<?php

namespace App\Http\Services\User;

use App\Contracts\RestFul\Ret\RetInterface;
use App\Http\Requests\IDRequest;
use App\Http\Requests\User\UserAddressIndexRequest;
use App\Http\Requests\User\UserAddressSaveRequest;
use App\Lib\RetJson;

class UserAddressService
{
    /**
     * 获取用户列表
     */
    public function getUserAddressList(UserAddressIndexRequest $request): RetInterface
    {
        return RetJson::pure()->msg('获取成功');
    }

    /**
     * 添加用户信息
     */
    public function saveUserAddress(UserAddressSaveRequest $request): RetInterface
    {
        return RetJson::pure()->msg('添加成功');
    }
    /**
     * 删除用户
     */
    public function deleteUserAddress(IDRequest $request): RetInterface
    {
        return RetJson::pure()->msg('删除成功');
    }
}
