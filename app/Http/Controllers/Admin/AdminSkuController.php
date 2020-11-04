<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\IDRequest;
use App\Http\Requests\User\Goods\AddSkuRequest;
use App\Http\Requests\User\Goods\IndexSKUSRequest;
use App\Http\Requests\User\Goods\SaveSkuRequest;
use App\Http\Services\Admin\AdminSkuService;

class AdminSkuController extends Controller
{

    public function AddSKU(AddSkuRequest $request, AdminSkuService $service)
    {
        return $this->api->reply($service->AddSKU($request));
    }


    public function deleteSkU(IDRequest $request, AdminSkuService $service)
    {
        return $this->api->reply($service->deleteSKU($request));
    }

    public function saveSKU(SaveSkuRequest $request, AdminSkuService $service)
    {
        return $this->api->reply($service->saveSKU($request));
    }


    public function getSKUS(IndexSKUSRequest $request, AdminSkuService $service)
    {
        return $this->api->reply($service->getSKUS($request));
    }
}
