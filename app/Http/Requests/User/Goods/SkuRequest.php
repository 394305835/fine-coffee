<?php

namespace App\Http\Requests\Goods;

use App\Http\Requests\BaseRequest;

class SkuRequest extends BaseRequest
{

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'id' => 'required|integer|min:1',
            'number' => 'integer',
        ];
    }

    public function messages()
    {
        return [
            'id.required' => 'id不能为空',
            'id.integer'  => 'id只能是整数',
            'id.min'      => 'id参数非法',
            'number.integer'  => 'number只能是整数'
        ];
    }
}
