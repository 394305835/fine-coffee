<?php

namespace App\Http\Requests\User;

use App\Http\Requests\BaseRequest;

/**
 * 用户管理-获取
 * @author qrj
 */
class UserAddressIndexRequest extends BaseRequest
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
            'search' => '', // 搜索内容，可按 id 和昵称搜索 这三个在验证器中均无法验证，只有在服务层做
            'orderBy'   => '', // 排序字段  这三个在验证器中均无法验证，只有在服务层做
            'order'     => '', // 排序方式  这三个在验证器中均无法验证，只有在服务层做
            'page'     => 'integer|min:0', // 页条数
            'limit'    => 'integer|min:5', // 页条数
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
