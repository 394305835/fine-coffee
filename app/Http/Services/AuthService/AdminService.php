<?php


namespace App\Http\Services\AuthService;

use Illuminate\Http\Request;


class AdminService
{
    /**
     * 权限管理-角色组-列表获取
     *
     * @param Request $request
     * @return PsrResponseInterface
     */
    public function getAdminList(Request $request)
    {
    }

    /**
     * 权限管理-角色组-保存或添加
     *
     * @param Request $request
     * @return PsrResponseInterface
     */
    public function saveAdmin(Request $request)
    {
        dd(1);
    }

    /**
     * 权限管理-管理员-删除,支持多个
     *
     * @param Request $request
     * @return PsrResponseInterface
     */
    public function deleteAdmin(Request $request)
    {
    }

    /**
     * 日志管理-获取
     *
     * @param Request $request
     * @return PsrResponseInterface
     */
    public function getAdminLogs(Request $request)
    {
    }
}
