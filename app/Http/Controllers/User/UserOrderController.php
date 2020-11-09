<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Http\Requests\User\UserOrderCartRequest;
use App\Http\Requests\User\UserOrderRequest;
use App\Http\Services\User\UserOrderService;

class UserOrderController extends Controller
{
    /**
     * 用户订单查询
     *
     * @param UserOrderRequest $request
     * @param UserOrderService $service
     * @return void
     */
    public function getOrderList(UserOrderRequest $request, UserOrderService $service)
    {
        return $this->api->reply($service->getOrderList($request));
    }
    /**
     * 用户购物车信息查询
     *
     * @param UserOrderRequest $request
     * @param UserOrderService $service
     * @return void
     */
    public function getOrderCartList(UserOrderCartRequest $request, UserOrderService $service)
    {
        return $this->api->reply($service->getOrderCartList($request));
    }
}
