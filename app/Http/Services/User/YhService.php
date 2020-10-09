<?php

namespace App\Http\Services\User;

use App\Contracts\RestFul\Ret\RetInterface;
use App\Http\Requests\User\UserIndexRequest;
use App\Http\Requests\User\UserSaveRequest;
use App\Lib\RetJson;
use App\Repositories\User;

/**
 * 用户新增 或者操作类
 */
class YhService extends UserBaseService
{
    /**
     * 获取用户列表
     */
    public function getUserList(UserIndexRequest $request): RetInterface
    {
        return RetJson::pure()->msg('获取成功');
    }

    /**
     * 添加用户信息
     */
    public function saveUser(UserSaveRequest $request): RetInterface
    {
        /**
         * 拿到用户要添加的信息
         * 判断用户是否存在--判断手机是否存在
         * 将数据添加到数据表中去
         */
        //$post代表从验证器中拿到的数据,代表要添加的列表
        $post = $request->only(array_keys($request->rules()));
        $user = User::singleton()->hasUserByUsernameOrPhone($post['username'], $post['phone']);
        if (empty($user)) {
            User::singleton()->insert($post);
            return RetJson::pure()->msg('添加成功');
        } else {
            return RetJson::pure()->error('已存在');
        }
    }
}
