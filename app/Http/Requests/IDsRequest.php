<?php

namespace App\Http\Requests;


class IDsRequest extends BaseRequest
{

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'ids' => 'required|array',
            //  ids是数组 .*表示数组里面的元素
            'ids.*' => 'required|integer|min:0',
        ];
    }

    public function messages()
    {
        return [
            'ids.required' => 'id 参数非法',
            'ids.array' => 'id 参数应该是数组',
        ];
    }
}
