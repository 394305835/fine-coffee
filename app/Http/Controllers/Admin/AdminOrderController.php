<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\AdminOrderCartRequest;
use App\Http\Requests\AdminOrderRequest;
use App\Http\Services\Admin\AdminOrderService;

class AdminOrderController extends Controller
{
    /**
     * 后台订单查询
     *
     * @param AdminOrderRequest $request
     * @param AdminOrderService $service
     * @return void
     */
    public function getOrderList(AdminOrderRequest $request, AdminOrderService $service)
    {
        return $this->api->reply($service->getOrderList($request));
    }
    /**
     * 后台购物车信息查询
     *
     * @param AdminOrderRequest $request
     * @param AdminOrderService $service
     * @return void
     */
    public function getOrderCartList(AdminOrderCartRequest $request, AdminOrderService $service)
    {
        return $this->api->reply($service->getOrderCartList($request));
    }
}
