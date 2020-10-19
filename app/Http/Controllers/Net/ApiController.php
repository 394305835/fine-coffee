<?php

namespace App\Http\Controllers\Net;

use App\Http\Controllers\Controller;
use App\Http\Requests\OrderNotifRequest;
use App\Http\Services\Net\ApiService;

class ApiController extends Controller
{
    /**
     * 用户支付成功回调
     *
     * @param ApiService $service
     * @return void
     */
    public function orderNotif(OrderNotifRequest $request, ApiService $service)
    {
        return $this->api->reply($service->orderNotif($request));
    }
}
