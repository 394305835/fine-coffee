<?php

namespace App\Http\Requests;



/**
 * 登录验证
 * @author qrj
 */
class AuthAdminLoginRequest extends BaseRequest
{

    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     */
    public function rules(): array
    {
        return [
            'username' => 'required',
            'password' => 'required',
        ];
    }

    /**
     * Get custom messages for validator errors.
     */
    public function messages(): array
    {
        return [
            'username.required'   => '用户名不能为空',
            'password.required'   => '密码不能为空',
        ];
    }
}
