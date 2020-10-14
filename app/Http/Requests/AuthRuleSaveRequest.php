<?php

namespace App\Http\Requests;


/**
 * 权限管理-菜单管理-添加或编辑验证
 * @author qrj
 */
class AuthRuleSaveRequest extends BaseRequest
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
            'id'     => 'integer|min:1', // 保存时需要传递ID
            'pid'    => 'integer|min:0', // 该权限所属上级
            'title'  => 'required', // 规则标题
            'path'   => 'required', // 权限名称，就是 url
            'icon'   => '', // 图标
            'meta'   => '',
            'sort'   => 'required|integer', // 权重
            'status' => 'required|in:0,1', // 状态 1正常 0禁用
        ];
    }

    /**
     * Get custom messages for validator errors.
     */
    public function messages(): array
    {
        return [
            'id.required'   => 'id 参数非法',
            'id.min'        => 'id 参数非法',
            'pid'           => '父级节点参数错误',
            'title.require' => '规则标题不能为空',
            'path.require'  => '规则不能为空',
            'sort'             => '权重值参数不正确',
            'status.required'   => '规则状态不能为空',
        ];
    }
}
