<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Http\Requests\IDRequest;
use App\Http\Requests\User\Goods\GoodsIndexRequest;
use App\Http\Services\User\GoodsService;

class GoodsController extends Controller
{
    public function getGoodsList(GoodsIndexRequest $request, GoodsService $service)
    {
        return $this->api->reply($service->getGoodsList($request));
    }

    public function getGoodsInfo(IDRequest $request, GoodsService $service)
    {
        return $this->api->reply($service->getGoodsInfo($request));
    }
}
