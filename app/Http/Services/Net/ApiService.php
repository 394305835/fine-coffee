<?php


namespace App\Http\Services\Net;

use App\Contracts\RestFul\Ret\RetInterface;
use App\Http\Requests\OrderNotifRequest;
use App\Lib\RetJson;
use App\Repositories\Order;
use Illuminate\Http\Request;

class ApiService
{

    /**
     * 用户支付成功回调
     * @param Request $request
     * @return RetInterface
     */
    public function orderNotif(OrderNotifRequest $request): RetInterface
    {
        $uuid = $request->input('uuid');
        $repo = Order::singleton();
        $order = $repo->getOrderByUuid($uuid);
        if ($order) {
            $repo->updateByUuid($uuid, ['pay_status' => Order::PAY_OK]);
        }

        return RetJson::pure()->entity();
    }
}
