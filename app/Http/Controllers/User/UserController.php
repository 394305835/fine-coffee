<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Http\Requests\User\UserIndexRequest;
use App\Http\Requests\User\UserSaveRequest;
use App\Http\Services\User\YhService;
use Illuminate\Http\Request;

class UserController extends Controller
{
    /**
     * 获取用户个人信息
     *
     * @param Request $request
     * @param YhService $service
     * @return void
     */
    public function getUserInfo(Request $request, YhService $service)
    {
        // 2.1为什么要获取请求对象？因为接口需要的只有从请求对象里面获取
        $res = $service->getUserInfo($request);
        // 在2.1和2.2之间需要处理响应内容
        // 2.2为什么要返回响应？因为我们要把数据给憨批，让憨批渲染。
        return $this->api->reply($res);
    }

    // /**
    //  * 用户-列表
    //  *
    //  * @param UserIndexRequest $request
    //  * @param UserService $service
    //  * @return PsrResponseInterface
    //  */
    // public function index(UserIndexRequest $request, YhService $service)
    // {
    //     return $this->api->reply($service->getUserList($request));
    // }

    /**
     * 用户管理-用户-修改
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
