<?php

namespace App\Http\Controllers;

use App\Contracts\RestFul\RESTFulAPI;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller as BaseController;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    /**
     * 请求实例
     *
     * @var Request
     */
    protected $request;

    /**
     * api 响应实例
     *
     * @var \App\Lib\RestFul\JsonAPI
     */
    protected $api;

    public function __construct(Request $request, RESTFulAPI $api)
    {
        $this->request = $request;
        $this->api = $api;
    }
}
