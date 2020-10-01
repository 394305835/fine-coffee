<?php


namespace App\Http\Services\AuthService;

use Illuminate\Http\Request;

class GroupService
{
    /**
     * 权限管理-角色组-列表获取
     *
     * @param Request $request
     * @return PsrResponseInterface
     */
    public function getGroupList(Request $request, bool $hasHandler = false)
    {
    }

    /**
     * 权限管理-角色组-下拉列表
     *
     * @param Request $request
     * @return PsrResponseInterface
     */
    public function getSelect(Request $request)
    {
    }

    /**
     * 权限管理-角色组-保存或添加
     *
     * @param Request $request
     * @return PsrResponseInterface
     */
    public function saveGroup(Request $request)
    {
    }

    /**
     * 权限管理-角色组-删除,支持多个
     *
     * @param Request $request
     * @return PsrResponseInterface
     */
    public function deleteGroup(Request $request)
    {
    }
}
