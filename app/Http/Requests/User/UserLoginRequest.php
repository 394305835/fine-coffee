<?php


namespace App\Http\Requests\User;

use App\Http\Requests\BaseRequest;

/**
 * 权限管理-管理员日志-获取
 * @author qrj
 */
class UserLoginRequest extends BaseRequest
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
            'search'    => '', // 搜索内容，可按 id 和昵称搜索
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
