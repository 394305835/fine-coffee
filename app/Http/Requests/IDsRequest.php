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
            'id' => 'required|separation'
        ];
    }

    public function messages()
    {
        return [
            'id.separation' => '参数格式不正确'
        ];
    }
}
