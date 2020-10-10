<?php

namespace App\Http\Requests\User;

use App\Http\Requests\BaseRequest;

/**
 * 用户管理-获取
 * @author qrj
 */
class UserAddressAddRequest extends BaseRequest
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
            'name' => 'required', //用户姓名
            'sex' => 'required', //性别
            'phone'    => 'required', //手机号码
            'address'   => 'required', //配送地址
            'address_detailed'     => 'required', // 详细配送地址
            'tag'     => '', //配送地址类型(家，学校，公司)
            'is_default_address'    => '', //是否是默认地址
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
