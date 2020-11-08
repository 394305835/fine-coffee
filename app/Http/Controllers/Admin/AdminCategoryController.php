<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\User\Goods\IndexCategorysRequest;
use App\Http\Requests\IDRequest;
use App\Http\Requests\User\Goods\AddCategoryRequest;
use App\Http\Requests\User\Goods\SaveCategoryRequest;
use App\Http\Services\Admin\AdminCategoryService;

class AdminCategoryController extends Controller
{
    /**
     * 增加商品分类
     *
     * @param AddCategoryRequest $request
     * @param AdminCategoryService $service
     * @return void
     */
    public function AddCategory(AddCategoryRequest $request, AdminCategoryService $service)
    {
        return $this->api->reply($service->AddCategory($request));
    }

    /**
     * 删除商品分类
     *
     * @param IDRequest $request
     * @param AdminCategoryService $service
     * @return void
     */
    public function deleteCategory(IDRequest $request, AdminCategoryService $service)
    {
        return $this->api->reply($service->deleteCategory($request));
    }

    /**
     * 修改商品分类
     *
     * @param SaveCategoryRequest $request
     * @param AdminCategoryService $service
     * @return void
     */
    public function saveCategory(SaveCategoryRequest $request, AdminCategoryService $service)
    {
        return $this->api->reply($service->saveCategory($request));
    }

    /**
     * 查询商品分类
     *
     * @param IndexCategorysRequest $request
     * @param AdminCategoryService $service
     * @return void
     */
    public function getCategorys(IndexCategorysRequest $request, AdminCategoryService $service)
    {
        return $this->api->reply($service->getCategorys($request));
    }
}
