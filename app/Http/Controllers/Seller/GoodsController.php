<?php

namespace App\Http\Controllers\Seller;

use App\Http\Controllers\Controller;
use App\Http\Requests\Seller\GoodsListRequest;
use App\Http\Services\Seller\GoodsService;

class GoodsController extends Controller
{
    /**
     * 商品信息列表获取
     *
     * @param GoodsService $service
     * @return void
     */
    public function getGoodsList(GoodsListRequest $request, GoodsService $service)
    {
        return $this->api->reply($service->getGoodsList($request));
    }
}
