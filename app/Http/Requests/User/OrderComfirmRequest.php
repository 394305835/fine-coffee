<?php

namespace App\Http\Requests\User;

use App\Http\Requests\BaseRequest;

class OrderComfirmRequest extends BaseRequest
{

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'goods_id' => 'required|integer|min:0', // 商品ID
            'sign' => 'required', // 购买商品前的 token
            'type_id' => 'required|array', // 购买商品的属性Id
            'type_id.*' => 'required|integer|min:0',
            'number' => 'required', // 购买商品数量
        ];
    }

    public function messages()
    {
        return [
            'sign.required' => 'id 参数非法',
            'type_id.required' => 'id 参数非法',
            'type_id.array' => 'id 参数应该是数组',
            'number.required' => '数量参数非法',

        ];
    }
}
