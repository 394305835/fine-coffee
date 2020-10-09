<?php

namespace App\Http\Requests;


class SMSRequest extends BaseRequest
{

    /**
     * 验证码
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'phone' => 'required'
        ];
    }

    public function messages()
    {
        return [
            'phone.required' => '手机号不能为空',
        ];
    }
}
