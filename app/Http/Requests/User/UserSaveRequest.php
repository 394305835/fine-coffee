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
            'theme' => '', // 头像
            'sex' => '', // 性别
            'username' => '', // 姓名
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
