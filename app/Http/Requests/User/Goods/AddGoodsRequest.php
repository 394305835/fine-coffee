<?php

namespace App\Http\Requests\User\Goods;

use App\Http\Requests\BaseRequest;

/**
 * 商品--商品添加
 * @author qrj
 */
class AddGoodsRequest extends BaseRequest
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
            'theme' => 'required',
            'name' => 'required',
            'subtitle' => 'required',
            'price' => 'required',
            'section_id' => 'required',
            'type_id' => 'required',
        ];
    }

    /**
     * Get custom messages for validator errors.
     */
    public function messages(): array
    {
        return [
            'id.required' => 'id不能为空',
            'section.required' => 'section_id不能为空',
            'type.required' => 'type_id不能为空',
            'name.required' => 'name不能为空',
            'theme.required' => 'theme不能为空',
            'subtitle.required'    => 'subtitle不能为空',
            'price.required'    => 'price不能为空',
        ];
    }
}
