<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Services\Admin\ApiService;
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
        $fields = ['id', 'pid', 'path', 'title', 'meta'];
        // $fields = ['id', 'pid', 'path', 'component', 'redirect', 'name', 'meta'];
        return $this->api->reply($service->getSelect($request, AuthRule::TYPE_ROUTER, $fields));
    }

    /**
     * 后台管理员修改头像
     *
     * @param ApiService $service
     * @return void
     */
    public function upAdminFile(ApiService $service)
    {
        return $this->api->reply($service->saveAdminTheme($this->request));
    }
}
