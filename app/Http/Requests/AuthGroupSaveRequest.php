<?php

namespace App\Http\Requests;



/**
 * 权限管理-角色管理-添加或编辑验证
 * @author qrj
 */
class AuthGroupSaveRequest extends BaseRequest
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
            'id' => 'integer|min:0', // 角色ID, 最小0,用于编辑修改
            // @TIP #1 目前只允许有一根角色组
            'pid' => 'required|integer|min:1', // 角色父角色ID, 最小1
            'name' => 'required', // 角色名
            'rules' => 'required|array', // 规则ID
            'rules.*' => 'required|integer|min:0',
            'rules_default' => 'required|array', // 规则ID
            'status' => 'required|integer|in:0,1',
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
