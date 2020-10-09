<?php

namespace App\Http\Services\User;

use App\Contracts\RestFul\Ret\RetInterface;
use App\Contracts\Token\TokenInterface;
use App\Http\Requests\User\UserLoginRequest;
use App\Lib\RetJson;
use App\Repositories\SMS;
use App\Repositories\User;
use App\Repositories\Token\UserToken;
use Illuminate\Http\Request;

/**
 * 用户登录
 */
class LoginService extends UserBaseService
{
    /**
     * @var TokenInterface
     */
    protected $token;

    /**
     * Undocumented variable
     *
     * @var $Token
     */
    protected $UserToken;
    public function __construct(TokenInterface $token)
    {
        $this->UserToken = UserToken::singleton();
        $this->token = $token->use($this->UserToken);
    }

    /**
     * 用户登录
     *
     * @Override
     * @param Request $request
     * @return RetInterface
     */
    public function login(UserLoginRequest $request): RetInterface
    {
        //接受手机号和验证码来在redis里面验证手机号的验证码是否存在，如果存在那么验证是否相等，如果相等就登录
        // 不存在就提示过期然后返回
        //接收手机号和验证码
        $phone = $request->input('phone');
        $code = $request->input('code');
        $smsCode = SMS::singleton()->getSMS($phone);
        if ($smsCode) {
            if ($code == $smsCode) {
                $ret = $this->singup($request);
                $res = $ret->getBody();
                if (!empty($uid = $res['entity']['id'])) {
                    $type = 'apiKey';
                    $repeat = true;
                    $key = 'Authorization';
                    $void = false;
                    // 获取 token 是否已经存在
                    if (!$token = $this->UserToken->getToken((int) $uid)) {
                        $repeat = false;
                        $token = $this->token->create(['uid' => $uid]);
                    }
                    // 刷新 Token
                    $repeat && $this->token->refresh($token);
                    return RetJson::pure()->setBody(compact('token', 'type', 'repeat', 'key', 'void'));
                } else {
                    return RetJson::pure()->error('登录失败');
                }
            } else {
                return RetJson::pure()->error('验证码输入错误');
            }
        } else {
            return RetJson::pure()->error('验证码过期');
        }
    }

    /**
     * 注册
     */
    public function singup(Request $request): RetInterface
    {
        $phone = $request->input('phone');
        $uid = User::singleton('id')->findByPhone($phone);
        if ($uid) {
            return RetJson::pure()->entity($uid->toArray());
        }
        $uid = User::singleton()->insertGetId([
            'theme' => '',
            'username' => $phone,
            'sex' => '男',
            'phone' => $phone,
            'money' => 0,
        ]);
        return RetJson::pure()->entity(['id' => $uid]);
    }

    /**
     * 用户登出
     *
     * @Override
     * @param Request $request
     * @return RetInterface
     */
    // public function logout(Request $request): RetInterface
    // {
    // }
}
