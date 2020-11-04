<?php

namespace App\Http\Requests\User\Goods;

use App\Http\Requests\BaseRequest;

/**
 * 权限管理-菜单管理-获取
 * @author qrj
 */
class IndexTypesRequest extends BaseRequest
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
            'id'   => 'integer',
            'section_id'   => 'integer',
            'title'   => '',
        ];
    }

    /**
     * Get custom messages for validator errors.
     */
    public function messages(): array
    {
        return [
            'id.integer' => 'id只能为整数',
            'section_id.integer' => 'section_id只能为整数',
        ];
    }
}
