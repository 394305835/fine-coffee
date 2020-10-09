<?php

namespace App\Http\Services\User;

use App\Contracts\RestFul\Ret\RetInterface;
use App\Http\Requests\User\UserLoginRequest;
use App\Lib\RetJson;
use App\Repositories\SMS;
use App\Repositories\User;
use Illuminate\Http\Request;

/**
 * 用户登录
 */
class LoginService extends UserBaseService
{
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
                if (!empty($res['entity']['id'])) {
                    return RetJson::pure()->msg('登录成功');
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
