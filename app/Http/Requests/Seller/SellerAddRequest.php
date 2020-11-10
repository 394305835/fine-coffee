<?php

namespace App\Http\Requests\Seller;

use App\Http\Requests\BaseRequest;

/**
 * 权限管理-管理员管理-添加或编辑验证
 * @author qrj
 */
class SellerAddRequest extends BaseRequest
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
            'number' => 'required|integer|min:0', // 管理员ID, 最小0,用于编辑修改
            'theme' => 'required', // 商家头像
            'username' => 'required', // 商家账户
            'address' => 'required', // 商家地址
            'password' => 'required', // 商家密码
        ];
    }

    /**
     * Get custom messages for validator errors.
     */
    public function messages(): array
    {
        return [
            'number.id' => '商家ID不能为空',
            'number.required' => '商家编号不能为空',
            'number.integer' => '商家必须是整数',
            'number.required' => '商家编号最小为0',
            'theme.required' => '商家头像不能为空',
            'username.required' => '商家账户不能为空',
            'address.required' => '商家地址不能为空',
            'password.required' => '商家密码不能为空'
        ];
    }
}
