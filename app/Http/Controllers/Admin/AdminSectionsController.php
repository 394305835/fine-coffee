<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\IDRequest;
use App\Http\Requests\User\Goods\AddSectionsRequest;
use App\Http\Requests\User\Goods\IndexSectionsRequest;
use App\Http\Requests\User\Goods\SaveSectionsRequest;
use App\Http\Services\Admin\AdminSectionsService;

class AdminSectionsController extends Controller
{
    /**
     * 增加商品属性
     *
     * @param AddSectionsRequest $request
     * @param AdminSectionsService $service
     * @return void
     */
    public function addSections(AddSectionsRequest $request, AdminSectionsService $service)
    {
        return $this->api->reply($service->addSections($request));
    }

    /**
     * 删除商品属性
     *
     * @param IDRequest $request
     * @param AdminSectionsService $service
     * @return void
     */
    public function deleteSections(IDRequest $request, AdminSectionsService $service)
    {
        return $this->api->reply($service->deleteSections($request));
    }

    /**
     * 修改商品属性
     *
     * @param AddSectionsRequest $request
     * @param AdminSectionsService $service
     * @return void
     */
    public function saveSections(SaveSectionsRequest $request, AdminSectionsService $service)
    {
        return $this->api->reply($service->saveSections($request));
    }

    /**
     * 查询商品属性
     *
     * @param IndexSectionsRequest $request
     * @param AdminSectionsService $service
     * @return void
     */
    public function getSections(IndexSectionsRequest $request, AdminSectionsService $service)
    {
        return $this->api->reply($service->getSections($request));
    }
}
