<?php

namespace App\Http\Requests\Seller;

use App\Http\Requests\BaseRequest;

/**
 * 权限管理-管理员管理-添加或编辑验证
 * @author qrj
 */
class SellerSaveRequest extends BaseRequest
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
            'id' => 'required',
            'theme' => '', // 商家头像
            'username' => '', // 商家账户
            'address' => '', // 商家地址
            'password' => '', // 商家密码
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
