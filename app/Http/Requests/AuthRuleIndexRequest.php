<?php

namespace App\Http\Requests;


/**
 * 权限管理-菜单管理-获取
 * @author qrj
 */
class AuthRuleIndexRequest extends BaseRequest
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
            'is_menu'   => 'integer|in:0,1', // 是否是菜单 1是 0否
            'title'     => '', // 规则标题
            'name'      => '', // 权限名称，就是 url
            'group_id'  => 'integer|min:0', // 组ID
            // 'weigh'  => 'integer', // 权重
            'status'    => 'in:0,1', // 状态 1正常 0禁用
            'orderBy'   => '', // 排序字段 ['id', 'weigh']
            'order'     => '', // 排序方式 0:asc 或 1:desc
            'search'    => '', // 搜索内容，可按 id 和规则名
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
