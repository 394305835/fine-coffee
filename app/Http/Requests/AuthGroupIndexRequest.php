<?php

namespace App\Http\Requests;



/**
 * 权限管理-角色组-获取
 * @author qrj
 */
class AuthGroupIndexRequest extends BaseRequest
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
            'hidden'    => 'in:0,1', // 是否显示隐藏组 1否(默认) 0是
            'is_menu'   => 'in:0,1', // 是否是菜单 1是 0不是
            'group_id'  => 'integer|min:0', // 组ID
            'status'    => 'in:0,1', // 状态 1正常 0禁用
            'orderBy'   => '', // 排序字段 ['id']
            'order'     => '', // 排序方式 0:asc 或 1:desc
            'page'     => 'integer|min:0', // 页条数
            'limit'    => 'integer|min:5', // 页条数
            'search'    => '', // 搜索内容，可按 id 和昵称搜索
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
