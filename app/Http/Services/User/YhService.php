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


    // /**
    //  * 获取个人用户列表
    //  */
    // public function getUserInfo($request): RetInterface
    // {
    //     // 2.2.2.由于获取用户接口是认证后的，可以直接知道用户的ID（一般用常量保存起来）
    //     // USER_UID;
    //     // 2.2.3 . 将用户ID交给仓库代查用户的信息
    //     $user = User::singleton()->getUserInfoById(USER_UID);
    //     // 然后返回给2.2
    //     return RetJson::pure()->entity($user);
    // }












    /**
     * 获取用户列表
     */
    public function getUserList(UserIndexRequest $request): RetInterface
    {
        return RetJson::pure()->msg('获取成功');
    }

    /**
     * 修改用户信息
     */
    public function saveUser(UserSaveRequest $request): RetInterface
    {
        /**
         * 1. 拿到要修改用户的UID  
         * 2. 拿到用户要修改的信息(头像，用户名，性别)
         * 3. 判断哪个字段有值，需要修改的
         * 4. 将数据添加到数据库中去
         * 5. 返回提示信息
         * 
         */
        $post = $request->only(array_keys($request->rules()));
        if (empty($post)) {
            return RetJson::pure()->msg('修改成功');
        }
        $bean = [];
        if (!empty($post['username'])) {
            $bean['username'] = $post['username'];
        }
        if (!empty($post['theme'])) {
            $bean['theme'] = $post['theme'];
        }
        if (!empty($post['sex'])) {
            $bean['sex'] = $post['sex'];
        }
        User::singleton()->updateById(USER_UID, $bean);
        return RetJson::pure()->msg('修改成功');
    }
}
