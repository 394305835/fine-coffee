<?php

namespace App\Http\Services\Seller;

use App\Contracts\RestFul\Ret\RetInterface;
use App\Contracts\Service\Access\LoginServiceInterface;
use App\Contracts\Token\TokenInfo;
use App\Contracts\Token\TokenInterface;
use App\Lib\Jwt\SellerJwt;
use App\Lib\RetCode;
use App\Lib\RetJson;
use App\Repositories\Seller;
use App\Repositories\Token\SellerToken;
use Illuminate\Http\Request;


/**
 * 有关商家登录登出服务
 */
class LoginService implements LoginServiceInterface
{

    /**
     * @var SellerJwt
     */
    protected $token;


    public function __construct()
    {
        $this->token = SellerJwt::singleton();
    }

    /**
     * 登录
     *
     * @param Request $request
     * @return RetInterface
     */
    public function login(Request $request): RetInterface
    {
        $repo = Seller::singleton('id', 'password');
        $username = $request->input('username');
        $password = $request->input('password');
        $ret = RetJson::pure();
        $seller = $repo->getSellerByUserName($username);

        if ($seller) {
            $info = new TokenInfo('Authorization');
            $info->repeat = true;
            
            try {
                if (decrypt($seller->password) != $password) {
                    return $ret->setRetCode(RetCode::AUTH_USER_WRONG_PASSWORD)->error();
                }
            } catch (\Illuminate\Contracts\Encryption\DecryptException $e) {
                return $ret->setRetCode(RetCode::SERVER_ERROR)->error();
            }

            // 获取 token 是否已经存在
            if (!$info->token = $this->token->getRepo()->getToken($seller->id)) {
                $info->repeat = false;
                $info->token = $this->token->create(['uid' => $seller->id]);
            }
            // 刷新 Token
            $info->repeat && $this->token->refresh($info->token);
            unset($seller->password);
            return $ret->setBody($info);
        }
        return $ret->setRetCode(RetCode::AUTH_USER_NOT_EXIST)->error();
    }

    /**
     * 登出
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
            if ($payload->uid) {
                $this->token->getRepo()->remove($payload->uid);
            }
        }
        return RetJson::pure()->msg();
    }

    /**
     * 注册
     *
     * @param Request $request
     * @return RetInterface
     */
    public function signup(Request $request): RetInterface
    {
        return RetJson::pure();
    }
}
