<?php

namespace App\Http\Services;

use App\Contracts\RestFul\Ret\RetInterface;
use App\Contracts\Service\UserServiceInterface;
use App\Contracts\Token\TokenInterface;
use App\Http\Requests\CipherRequest;
use App\Lib\RetCode;
use App\Lib\RetJson;
use App\Lib\Utils;
use App\Repositories\TokenRedis;
use App\Repositories\User;
use Illuminate\Http\Request;

class UserService implements UserServiceInterface
{

    /**
     * token 实例
     *
     * @var TokenInterface
     */
    protected $token;

    public function __construct(TokenInterface $token)
    {
        $this->token = $token;
    }

    /**
     * 用户登录
     *
     * @Override
     * @param Request $request
     * @return RetInterface
     */
    public function login(Request $request): RetInterface
    {
        $repo = User::singleton('id', 'password');
        $username = $request->input('username');
        $password = $request->input('password');
        $ret = RetJson::pure();
        $user = $repo->findByUsername($username);

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
     * 用户注册
     *
     * @Override
     * @param Request $request
     * @return RetInterface
     */
    public function signup(Request $request): RetInterface
    {
        $repo = User::singleton();
        $username = $request->input('username');
        $password = encrypt($request->input('password'));
        $user = $repo->findByUsername($username);
        $ret = RetJson::pure();
        if (!$user) {
            $repo->insert(compact('username', 'password'));
            return $ret->setRetCode(RetCode::CREATED)->msg();
        }
        return $ret->setRetCode(RetCode::AUTH_USER_EXISTS)->error();
    }

    /**
     * 用户登出
     *
     * @Override
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
    /**
     * 获取一个用户信息
     *
     * @Override
     * @param Request $request
     * @return RetInterface
     */
    public function getUser(Request $request): RetInterface
    {
        return RetJson::pure();
    }

    /**
     * 获取列表型实体数据
     *
     * @Override
     * @param Request $request
     * @return RetInterface
     */
    public function getList(Request $request): RetInterface
    {
        return RetJson::pure();
    }

    /**
     * 下拉列表型的实体数据
     *
     * @Override
     * @param Request $request
     * @return RetInterface
     */
    public function getSelect(Request $request): RetInterface
    {
        return RetJson::pure();
    }

    /**
     * 保存用户的解密密文.
     *
     * 该密文是用户自己为了查看添加密码本密码的密文而用，类似密码盐
     *
     * @param CipherRequest $request
     * @return RetInterface
     */
    public function saveUserCipher(CipherRequest $request): RetInterface
    {
        $palint = $request->input('palint');
        $repo = User::singleton();
        try {
            $cipher = Utils::createDictCipher(REQUEST_UID, $palint);
            $repo->updateCipher(REQUEST_UID, $cipher);
        } catch (\Throwable $th) {
            return RetJson::pure()->throwable($th);
        }
        return RetJson::pure()->msg();
    }
}
