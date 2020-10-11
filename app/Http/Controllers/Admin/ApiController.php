<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Services\Admin\AuthService\RuleService;
use App\Repositories\AuthRule;
use Illuminate\Http\Request;

class ApiController extends Controller
{
    /**
     * 获取登录用户的可访问菜单
     *
     * @api
     * @param Request $request
     * @return PsrResponseInterface
     */
    public function getMenus(Request $request, RuleService $service)
    {
        return $this->api->reply($service->getSelect($request, AuthRule::TYPE_ROUTER));
    }
}
