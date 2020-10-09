<?php

namespace App\Http\Requests\User;

use App\Http\Requests\BaseRequest;

/**
 * 用户管理-添加或编辑验证
 * @author qrj
 */
class UserSaveRequest extends BaseRequest
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
            // LINK#1 限制组个数
            'adress_id' => 'integer|min:0', // 限制只能是一个组 
            'id' => 'integer|min:0', // 管理员ID, 最小0,用于编辑修改
            'username' => 'required', // 用户名
            'theme' => '', // 头像
            'sex' => 'required', // 性别
            'phone' => 'required|integer', // 手机号
        ];
    }

    /**
     * Get custom messages for validator errors.
     */
    public function messages(): array
    {
        return [];
    }
}
