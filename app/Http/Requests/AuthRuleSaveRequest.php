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
            'id'        => 'integer|min:1', // 保存时需要传递ID
            'is_menu'   => 'required|integer|in:0,1', // 是否是菜单 1是 0否
            'pid'       => 'integer|min:0', // 该权限所属上级
            'condition' => '', // 规则
            'title'     => 'required', // 规则标题
            'name'      => 'required', // 权限名称，就是 url
            'icon'      => '', // 图标
            'weigh'     => 'required|integer', // 权重
            'remark'    => '', // 备注
            'status'    => 'required|in:0,1', // 状态 1正常 0禁用
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
            'name.require'  => '规则不能为空',
            'weigh'             => '权重值参数不正确',
            'is_menu.required'  => '请选择是否为菜单',
            'status.required'   => '规则状态不能为空',
        ];
    }
}
