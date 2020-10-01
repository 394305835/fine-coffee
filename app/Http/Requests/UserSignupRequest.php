<?php

namespace App\Http\Requests;

/**
 * 用户登录请求实例
 */
class UserSignupRequest extends BaseRequest
{

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'username' => 'required',
            'password' => 'required'
        ];
    }

    public function messages()
    {
        return [
            'username.required' => '用户名不能为空',
            'password.integer'  => '密码不能为空',
        ];
    }
}
