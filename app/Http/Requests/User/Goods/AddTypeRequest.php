<?php

namespace App\Http\Requests\User\Goods;

use App\Http\Requests\BaseRequest;

/**
 * 商品--商品添加
 * @author qrj
 */
class AddTypeRequest extends BaseRequest
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
            'sectionId' => 'required',
            'title' => 'required',

        ];
    }

    /**
     * Get custom messages for validator errors.
     */
    public function messages(): array
    {
        return [
            'id.required' => 'id不能为空',
            'sectionId.required' => 'sectionId不能为空',
            'title.required' => 'title不能为空',
        ];
    }
}
