<?php

namespace App\Http\Requests\User\Goods;

use App\Http\Requests\BaseRequest;

/**
 * 商品--商品属性修改
 * @author qrj
 */
class SaveSectionsRequest extends BaseRequest
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
            'title' => 'required',
        ];
    }

    /**
     * Get custom messages for validator errors.
     */
    public function messages(): array
    {
        return [];
    }
}
