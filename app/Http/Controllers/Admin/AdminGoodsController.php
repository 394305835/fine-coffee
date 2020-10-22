<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\IDRequest;
use App\Http\Requests\User\Goods\AddGoodsRequest;
use App\Http\Requests\User\Goods\SaveGoodsRequest;
use App\Http\Services\Admin\AdminGoodsService;

class AdminGoodsController extends Controller
{
    /**
     * 增加商品
     *
     * @param AddGoodsRequest $request
     * @param AdminGoodsService $service
     * @return void
     */
    public function addGoods(AddGoodsRequest $request, AdminGoodsService $service)
    {
        return $this->api->reply($service->addGoods($request));
    }

    /**
     * 删除商品
     *
     * @param IDRequest $request
     * @param AdminGoodsService $service
     * @return void
     */
    public function deleteGoods(IDRequest $request, AdminGoodsService $service)
    {
        return $this->api->reply($service->deleteGoods($request));
    }

    /**
     * 修改商品
     *
     * @param SaveGoodsRequest $request
     * @param AdminGoodsService $service
     * @return void
     */
    public function saveGoods(SaveGoodsRequest $request, AdminGoodsService $service)
    {
        return $this->api->reply($service->saveGoods($request));
    }
}
