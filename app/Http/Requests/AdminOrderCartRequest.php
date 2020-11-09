<?php

namespace App\Http\Requests;


/**
 * 权限管理-管理员管理-获取
 * @author gx
 */
class AdminOrderCartRequest extends BaseRequest
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
            'name' => '',
            'search' => '', // 搜索内容，可按 id 和昵称搜索
            'status'    => 'in:0,1', // 状态 1正常 0禁用
            'orderBy'   => '', // 排序字段 ['id', 'login_time'], 使用数值
            'order'     => '', // 排序方式 0:asc 或 1:desc, 使用数值
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
