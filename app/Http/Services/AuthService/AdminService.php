<?php


namespace App\Http\Services\AuthService;

use App\Http\Requests\AuthAdminSaveRequest;
use App\Http\Requests\IDsRequest;
use App\Http\Services\AuthService;
use App\Lib\RetJson;
use App\Lib\Tree;
use App\Repositories\AuthAccess;
use App\Repositories\AuthAdmin;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class AdminService extends AuthService
{
    /**
     * 权限管理-管理员-列表获取(需要加上组表里面的角色名字)
     *
     * @param Request $request
     * @return PsrResponseInterface
     */
    public function getAdminList(Request $request)
    {
        $curreatuid = 1;
        // 1--获取下级用户的ID
        $subAllUids = $this->getSubUserIds($curreatuid);
        //用下级用户的ID来查询相应的ID对应的信息，最后用数组保存
        $subUser = AuthAdmin::singleton('id', 'username', 'nickname', 'avatar', 'email')
            ->getAdminByIds($subAllUids)->toArray();
        //下级用户所对应的组，用数组保存
        $groups = $this->getUserGroup($subAllUids)->toArray();
        //
        $access = $this->getGroupAccessByKey($subAllUids);
        //将需要的数据拼接成需要的格式
        $subUser = array_column($subUser, null, 'id');
        $groups = array_column($groups, null, 'id');
        foreach ($access as $_acc) {
            if (isset($groups[$_acc->group_id])) {
                $subUser[$_acc->uid]['name'] = $groups[$_acc->group_id]['name'];
            }
        }
        dd($subUser);
        return RetJson::pure()->list(array_values($subUser));
    }

    /**
     * 权限管理-管理员-增加和保存
     *
     * @param Request $request
     * @return PsrResponseInterface
     */
    public function saveAdmin(AuthAdminSaveRequest $request)
    {
        /**
         * 1--拿到当前用户的UID\
         * 2--得到这个UID用户的所有下属的组ID
         * 3--验证添加信息里面的组ID是否属于当前UID用户管
         * 4--提示信息或者入库
         */
        $curreatuid = 4;
        $post = $request->only(array_keys($request->rules()));
        if ($this->hasUserGroup($curreatuid, [$post['group_id']], true)) {
            $user = AuthAdmin::singleton('id')->getAdminByUserName($post['username']);
            if (empty($user)) {
                echo '入库插入成功';
            } else {
                echo '用户名已经存在';
            }
        } else {
            echo '无权限';
        }
    }

    /**
     * 权限管理-管理员-删除,支持多个
     *
     * @param Request $request
     * @return PsrResponseInterface
     */
    public function deleteAdmin(IDsRequest $request)
    {
        $subUids = $request->input('ids');
        //拿到要删除管理员的ID 可以是多个
        $curreatuid = 1;
        if ($this->hasUser($curreatuid, $subUids)) {
            foreach ($subUids as $_subId) {
                $subSubUser = $this->getSubUserIds($_subId);
                // dd($subSubUser);
                if (!empty($subSubUser)) {
                    echo $_subId . '下面还有人，不能删除';
                    exit;
                }
            }
            echo '删除成功';
        } else {
            echo '这些人都不是你手下的人';
        }

        //验证ID对应的用户是否有权限去删除，其中有一个不是就算失败

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
