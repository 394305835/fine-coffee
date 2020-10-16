<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Http\Requests\User\CreateOrderRequest;
use App\Http\Services\User\OrderService;
use Illuminate\Http\Request;

class OrderController extends Controller
{

    /**
     * 该方法提供了订单确认页面的的查询功能
     *
     * @param Request $request
     * @param OrderService $service
     * @return void
     */
    public function index(Request $request, OrderService $service)
    {
        return $this->api->reply($service->getOrderDetails($request));
    }

    public function createOrder(CreateOrderRequest $request, OrderService $service)
    {
        return $this->api->reply($service->createOrder($request));
    }
}
