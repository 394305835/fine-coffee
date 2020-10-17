<?php

namespace App\Http\Requests\User;

use App\Http\Requests\BaseRequest;

class OrderPayRequest extends BaseRequest
{

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'pay_id' => 'required|integer|min:0', // 支付ID
            'cart_id' => 'required|array', // 购物车ID
        ];
    }

    public function messages()
    {
        return [];
    }
}
