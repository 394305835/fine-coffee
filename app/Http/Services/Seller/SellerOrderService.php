<?php

namespace App\Http\Services\Seller;

use App\Contracts\RestFul\Ret\RetInterface;
use App\Http\Requests\Seller\SellerOrderCartRequest;
use App\Http\Requests\Seller\SellerOrderRequest;
use App\Lib\Parameter\LimitParam;
use App\Lib\Parameter\SortParam;
use App\Lib\Parameter\WhereParam;
use App\Lib\RetJson;
use App\Repositories\Order;
use App\Repositories\OrderCart;

class SellerOrderService
{
    /**
     * 商家订单查询
     *
     * @param SellerOrderRequest $request
     * @return RetInterface
     */
    public function getOrderList(SellerOrderRequest $request): RetInterface
    {
        //排序
        $sp = new SortParam();
        $sp->sort('id', 'desc');
        $sort = $sp->build();
        //分页
        list($limit) = (new LimitParam)->build();
        //条件
        list($where) = (new WhereParam())->compare('id')->compare('uuid')->compare('seller')->compare('seller_id')
            ->compare('pay_id')->compare('pay_status')->compare('status')->build();
        //数据--这里我想的是可以把数据查询出来再处理，不然有搜索条件就要查库,或者排序也要
        $orderList = Order::singleton()->getOrderBySellerId($limit, $sort, $where);
        return RetJson::pure()->list($orderList);
    }

    /**
     * 根据订单表UUID字段查询订单对应购物车详细信息
     *
     * @param [type] $request
     * @return RetInterface
     */
    public function getOrderCartList(SellerOrderCartRequest $request): RetInterface
    {
        //排序
        $sp = new SortParam();
        $sp->sort();
        $sort = $sp->build();
        //分页
        list($limit) = (new LimitParam)->build();
        //条件
        $uuid = (array)$request->input('uuid');
        $orderList = OrderCart::singleton()->getOrderCartByUuid($limit, $sort, $uuid);
        return RetJson::pure()->list($orderList);
    }
}
