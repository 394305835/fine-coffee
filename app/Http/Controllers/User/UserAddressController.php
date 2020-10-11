<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Http\Requests\IDRequest;
use App\Http\Requests\IDsRequest;
use App\Http\Requests\User\UserAddressIndexRequest;
use App\Http\Requests\User\UserAddressSaveRequest;
use App\Http\Requests\User\UserAddressAddRequest;
use App\Http\Requests\UserIndexRequest;
use App\Http\Requests\UserSaveRequest;
use App\Http\Services\User\UserAddressService;
use App\Http\Services\User\YhService;

class UserAddressController extends Controller
{

    /**
     * 用户-配送地址列表
     *
     * @param UserIndexRequest $request
     * @param UserService $service
     * @return PsrResponseInterface
     */
    public function index(UserAddressIndexRequest $request, UserAddressService $service)
    {
        return $this->api->reply($service->getUserAddressList($request));
    }

    /**
     * 用户管理-用户-配送地址新增
     *
     * @param UserSaveRequest $request
     * @param YhService $service
     * @return PsrResponseInterface
     */
    public function addAddress(UserAddressAddRequest $request, UserAddressService $service)
    {
        return $this->api->reply($service->addUserAddress($request));
    }
    /**
     * 用户管理-用户-配送地址修改
     *
     * @param UserSaveRequest $request
     * @param YhService $service
     * @return PsrResponseInterface
     */
    public function saveAddress(UserAddressSaveRequest $request, UserAddressService $service)
    {
        return $this->api->reply($service->saveUserAddress($request));
    }

    /**
     * 用户管理-用户-配送地址删除配送地址
     * @param IDsRequest $request
     * @param UserAddressService $service
     * @return PsrResponseInterface
     */
    public function deleteAddress(IDRequest $request, UserAddressService $service)
    {
        return $this->api->reply($service->deleteUserAddress($request));
    }
}
