<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Http\Requests\IDRequest;
use App\Http\Requests\User\Goods\GoodsIndexRequest;
use App\Http\Services\Seller\GoodsService;

class GoodsController extends Controller
{
    /**
     * 获取商品列表--通过分类来显示商品(全局商品列表获取)
     *
     * @param GoodsIndexRequest $request
     * @param GoodsService $service
     * @return void
     */
    public function getGoodsList(GoodsIndexRequest $request, GoodsService $service)
    {
        return $this->api->reply($service->getGoodsList($request));
    }

    /**
     * 获取商品详细信息(立即购买后)
     *
     * @param IDRequest $request
     * @param GoodsService $service
     * @return void
     */
    public function getGoodsInfo(IDRequest $request, GoodsService $service)
    {
        return $this->api->reply($service->getGoodsInfo($request));
    }
}
