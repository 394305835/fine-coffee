<?php

namespace App\Http\Requests;



/**
 * 权限管理-管理员管理-添加或编辑验证
 * @author qrj
 */
class AuthAdminSaveRequest extends BaseRequest
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
            // LINK#1 限制组个数
            'group_id' => 'required|integer|min:0', // 限制只能是一个组 
            // 'group_id' => 'required|array', // 所属组ID
            // 'group_id.*' => 'required|integer|min:0', // 所属组ID

            'id' => 'integer|min:0', // 管理员ID, 最小0,用于编辑修改
            'username' => 'required', // 用户名
            // 'nickname' => 'required', // 昵称
            // 'email' => 'required|email', // 邮箱
            // 'password' => 'required_without:id', // 密码
            // 'loginfailure' => 'integer|min:0', // 登录失败次数
            // 'status' => 'required|in:0,1', // 状态 1正常 0禁用
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
