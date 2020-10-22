<?php

namespace App\Http\Requests;


class OrderNotifRequest extends BaseRequest
{

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'uuid' => 'required',
            //  ids是数组 .*表示数组里面的元素
        ];
    }

    public function messages()
    {
        return [];
    }
}
