<?php

namespace App\Http\Controllers\Seller;

use App\Http\Controllers\Controller;
use App\Http\Requests\Seller\SellerOrderCartRequest;
use App\Http\Requests\Seller\SellerOrderRequest;
use App\Http\Services\Seller\SellerOrderService;

class SellerOrderController extends Controller
{
    /**
     * 商家订单查询
     *
     * @param SellerOrderRequest $request
     * @param UserOrderService $service
     * @return void
     */
    public function getOrderList(SellerOrderRequest $request, SellerOrderService $service)
    {
        return $this->api->reply($service->getOrderList($request));
    }
    /**
     * 商家购物车信息查询
     *
     * @param SellerOrderRequest $request
     * @param SellerOrderService $service
     * @return void
     */
    public function getOrderCartList(SellerOrderCartRequest $request, SellerOrderService $service)
    {
        return $this->api->reply($service->getOrderCartList($request));
    }
}
