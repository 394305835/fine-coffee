<?php

namespace App\Http\Services\User;

use App\Contracts\RestFul\Ret\RetInterface;
use App\Http\Requests\IDRequest;
use App\Http\Requests\User\UserAddressAddRequest;
use App\Http\Requests\User\UserAddressIndexRequest;
use App\Http\Requests\User\UserAddressSaveRequest;
use App\Lib\Parameter\LimitParam;
use App\Lib\Parameter\SortParam;
use App\Lib\RetJson;
use App\Repositories\UserAddress;

class UserAddressService
{
    /**
     * 获取用户响应地址列表
     */
    public function getUserAddressList(UserAddressIndexRequest $request): RetInterface
    {
        //分页    1--limit--每页多少条数据  2--offset--一共分页多少页  LimitParam是分页的对象
        $lp = new LimitParam();
        //list会分别取返回里面的值，并把这个值当成list列表中变量的值
        list($limit, $offset) = $lp->build();
        //排序    SortParam--是排序的对象  
        $sp = new SortParam();
        $sp->sort('id', 'desc');
        $sort = $sp->build();

        $address = UserAddress::singleton()->queryAddressByUserId(USER_UID, $sort, $limit);
        return RetJson::pure()->list($address);
    }

    /**
     * 添加用户地址
     */
    public function addUserAddress(UserAddressAddRequest $request): RetInterface
    {
        $post = $request->only(array_keys($request->rules()));
        $post['user_id'] = USER_UID;
        try {
            $user = UserAddress::singleton()->insert($post);
            if ($user) {
                return RetJson::pure()->msg('添加成功');
            }
        } catch (\Throwable $th) {
            return RetJson::pure()->throwable($th);
        }
        return RetJson::pure()->msg('添加失败');
    }
    /**
     * 修改用户地址
     */
    public function saveUserAddress(UserAddressSaveRequest $request): RetInterface
    {
        //需要修改的ID
        $id = (int) $request->input('id');
        //需要修改的数据
        $post = $request->only(array_keys($request->rules()));
        unset($post['id']);
        $user = UserAddress::singleton('id', 'user_id')->getAddressByKey($id, USER_UID);
        try {
            if ($user) {
                UserAddress::singleton()->updateById($id, $post);
            }
        } catch (\Throwable $th) {
            return RetJson::pure()->throwable($th);
        }
        return RetJson::pure()->msg('修改成功');
    }
    /**
     * 删除用户对应的地址
     */
    public function deleteUserAddress(IDRequest $request): RetInterface
    {
        $id = $request->input('id');
        try {
            $bool = UserAddress::singleton()->deleteAddressByKey((int)$id, USER_UID);
            if ($bool) {
                return RetJson::pure()->msg('删除成功');
            }
        } catch (\Throwable $th) {
            return RetJson::pure()->throwable($th);
        }
        return RetJson::pure()->msg('删除成功');
    }
}
