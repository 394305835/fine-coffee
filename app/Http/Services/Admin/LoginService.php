<?php


namespace App\Http\Services\Admin;

use App\Contracts\RestFul\Ret\RetInterface;
use App\Contracts\Token\TokenInterface;
use App\Http\Requests\AuthAdminLoginRequest;
use App\Lib\Jwt\AdminJwt;
use App\Lib\RetCode;
use App\Lib\RetJson;
use App\Repositories\AuthAdmin;
use App\Repositories\TokenRedis;
use Illuminate\Http\Request;

class LoginService
{
    /**
     * @var TokenInterface
     */
    protected $token;
    public function __construct()
    {
        $this->token = AdminJwt::singleton();
    }

    /**
     * 管理员后台登录
     *
     * @param Request $request
     * @return RetInterface
     */
    public function login(AuthAdminLoginRequest $request): RetInterface
    {
        $repo = AuthAdmin::singleton('id', 'password');
        $username = $request->input('username');
        $password = $request->input('password');
        $ret = RetJson::pure();
        $user = $repo->getAdminByUserName($username);

        if ($user) {
            $type = 'apiKey';
            $repeat = true;
            $key = 'Authorization';
            $void = false;

            try {
                if (decrypt($user->password) != $password) {
                    return $ret->setRetCode(RetCode::AUTH_USER_WRONG_PASSWORD)->error();
                }
            } catch (\Illuminate\Contracts\Encryption\DecryptException $e) {
                return $ret->setRetCode(RetCode::SERVER_ERROR)->error();
            }

            // 获取 token 是否已经存在
            if (!$token = TokenRedis::singleton()->getToken($user->id)) {
                $repeat = false;
                $token = $this->token->create(['uid' => $user->id]);
            }
            // 刷新 Token
            $repeat && $this->token->refresh($token);
            unset($user->password);
            return $ret->setBody(compact('token', 'type', 'repeat', 'key', 'void'));
        }
        return $ret->setRetCode(RetCode::AUTH_USER_NOT_EXIST)->error();
    }

    /**
     * 管理员后台退出
     *
     * @param Request $request
     * @return RetInterface
     */
    public function logout(Request $request): RetInterface
    {
        if (empty($token = $request->input('Authorization'))) {
            $token = $request->header('Authorization');
        }
        if ($token) {
            $payload = $this->token->getPayload($token);
            if ($payload && $payload->uid) {
                TokenRedis::singleton()->remove($payload->uid);
            }
        }
        return RetJson::pure()->msg();
    }
}
