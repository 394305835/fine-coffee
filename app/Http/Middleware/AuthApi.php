<?php

namespace App\Http\Middleware;

use App\Contracts\RestFul\RESTFulAPI;
use App\Contracts\Service\LogServiceInterface;
use App\Contracts\Token\TokenInterface;
use App\Lib\RetCode;
use App\Lib\RetJson;
use Illuminate\Http\Request;

class AuthApi
{
    /**
     * 日志服务
     *
     * @var LogServiceInterface
     */
    protected $log;

    /**
     * token 实例
     *
     * @var TokenInterface
     */
    protected $token;

    /**
     * api 实例
     *
     * @var RESTFulAPI
     */
    protected $api;

    public function __construct(TokenInterface $token, RESTFulAPI $api, LogServiceInterface $log)
    {
        $this->token = $token;
        $this->api = $api;
        $this->log = $log;
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
        // if (!$token = $request->header('Authorization')) {
        //     return $this->api->reply(RetJson::pure()->setCode(RetCode::AUTH_TOKEN_NULL)->error());
        // }

        if (empty($token = $request->input('Authorization'))) {
            $token = $request->header('Authorization');
        }
        if (empty($token)) {
            return $this->api->reply(RetJson::pure()->setRetCode(RetCode::AUTH_TOKEN_NULL)->error());
        }

        if (!$this->token->check($token)) {
            return $this->api->reply(RetJson::pure()->setRetCode(RetCode::AUTH_TOKEN_FAIL)->error());
        }

        // 刷新 token
        $this->token->refresh($token);

        /**
         * 用户身份ID
         */
        define('REQUEST_UID', $this->token->getPayload()->uid);

        // $this->log->write();

        return $next($request);
    }
}
