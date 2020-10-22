<?php


namespace App\Http\Requests\Seller;

use App\Http\Requests\BaseRequest;

/**
 * 
 * @author qrj
 */
class GoodsListRequest extends BaseRequest
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
            'name' => '', // 商品名称，模糊搜索
            'category' => 'integer|min:0', // 分类ID
            'page' => 'integer|min:0',
            'limit' => 'integer|min:3'
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
