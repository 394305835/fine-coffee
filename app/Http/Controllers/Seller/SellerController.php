<?php

namespace App\Http\Controllers\Seller;

use App\Http\Controllers\Controller;
use App\Http\Requests\IDsRequest;
use App\Http\Requests\Seller\SellerAddRequest;
use App\Http\Requests\Seller\SellerSaveRequest;
use App\Http\Services\Seller\SellerService;
use Illuminate\Http\Request;

class SellerController extends Controller
{
    /**
     * 当前登录商家信息
     *
     * @api
     * @param Request $request
     * @return PsrResponseInterface
     */
    public function getSellerInfo(Request $request, SellerService $service)
    {
        return $this->api->reply($service->getSellerInfo($request));
    }

    /**
     * 商家管理-商家-新增
     *
     * @param SellerSaveRequest $request
     * @param SellerService $service
     * @return PsrResponseInterface
     */
    public function addSeller(SellerAddRequest $request, SellerService $service)
    {
        return $this->api->reply($service->addSeller($request));
    }
    /**
     * 商家管理-商家-编辑
     *
     * @param SellerSaveRequest $request
     * @param SellerService $service
     * @return PsrResponseInterface
     */
    public function saveSeller(SellerSaveRequest $request, SellerService $service)
    {
        return $this->api->reply($service->saveSeller($request));
    }

    /**
     * 商家管理-商家-删除
     *
     * @param IDsRequest $request
     * @param SellerService $service
     * @return PsrResponseInterface
     */
    public function deleteSeller(IDsRequest $request, SellerService $service)
    {
        return $this->api->reply($service->deleteSeller($request));
    }
}
