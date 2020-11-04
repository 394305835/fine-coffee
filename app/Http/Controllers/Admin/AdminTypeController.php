<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\User\Goods\IndexTypesRequest;
use App\Http\Requests\IDRequest;
use App\Http\Requests\User\Goods\AddTypeRequest;
use App\Http\Requests\User\Goods\SaveTypeRequest;
use App\Http\Services\Admin\AdminTypeService;

class AdminTypeController extends Controller
{
    /**
     * 增加商品属性选择
     *
     * @param AddTypeRequest $request
     * @param AdminTypeService $service
     * @return void
     */
    public function AddType(AddTypeRequest $request, AdminTypeService $service)
    {
        return $this->api->reply($service->AddType($request));
    }

    /**
     * 删除商品属性选择
     *
     * @param IDRequest $request
     * @param AdminTypeService $service
     * @return void
     */
    public function deleteType(IDRequest $request, AdminTypeService $service)
    {
        return $this->api->reply($service->deleteType($request));
    }

    /**
     * 修改商品属性选择
     *
     * @param SaveTypeRequest $request
     * @param AdminTypeService $service
     * @return void
     */
    public function saveType(SaveTypeRequest $request, AdminTypeService $service)
    {
        return $this->api->reply($service->saveType($request));
    }

    /**
     * 查询商品属性选择
     *
     * @param IndexTypesRequest $request
     * @param AdminTypeService $service
     * @return void
     */
    public function getTypes(IndexTypesRequest $request, AdminTypeService $service)
    {
        return $this->api->reply($service->getTypes($request));
    }
}
