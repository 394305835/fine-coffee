<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Http\Services\User\GoodsService;
use Illuminate\Http\Request;

class GoodsController extends Controller
{
    public function getGoodsList(Request $request, GoodsService $service)
    {
        return $this->api->reply($service->getGoodsList($request));
    }
}
