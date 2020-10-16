<?php

namespace App\Http\Requests\User;

use App\Http\Requests\BaseRequest;

class CreateOrderRequest extends BaseRequest
{

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'gid' => 'required',
            'type_id' => 'required|array',
            //  ids是数组 .*表示数组里面的元素
            'type_id.*' => 'required|integer|min:0',
        ];
    }

    public function messages()
    {
        return [
            'gid.required' => 'id 参数非法',
            'type_id.required' => 'id 参数非法',
            'type_id.array' => 'id 参数应该是数组',
        ];
    }
}
