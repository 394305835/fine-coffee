<?php

namespace App\Http\Controllers\Seller;

use App\Http\Controllers\Controller;
use App\Http\Services\Seller\ApiService;

class ApiController extends Controller
{
    /**
     * 商户修改头像
     *
     * @param ApiService $service
     * @return void
     */
    public function upLoadTheme(ApiService $service)
    {
        return $this->api->reply($service->saveSellerTheme($this->request));
    }
}
