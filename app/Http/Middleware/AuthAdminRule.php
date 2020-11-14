<?php

namespace App\Http\Middleware;

use App\Contracts\RestFul\RESTFulAPI;
use App\Http\Services\Admin\AuthService\Auth;
use App\Lib\RetCode;
use App\Lib\RetJson;
use Illuminate\Http\Request;

/**
 * 后台访问接口鉴权
 */
class AuthAdminRule
{

    /**
     * api 实例
     *
     * @var RESTFulAPI
     */
    protected $api;

    /**
     * 鉴权实例
     *
     * @var Auth
     */
    protected $auth;

    public function __construct(RESTFulAPI $api, Auth $auth)
    {
        $this->api = $api;
        $this->auth = $auth;
    }

    /**
     * 处理传入的请求
     *
     * @param  Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle(Request $request, \Closure $next)
    {
        $path = $request->path();
        // $path = $request->getPathInfo();
        // $path = $request->route();

        if (!$this->auth->hasRuleByPath(REQUEST_UID, $path)) {
            return $this->api->reply(RetJson::make(401)->setRetCode(RetCode::AUTH_RULE_INVALID)->error());
        }

        return $next($request);
    }
}
