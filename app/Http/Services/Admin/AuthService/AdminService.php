<?php


namespace App\Http\Services\Admin\AuthService;

use App\Contracts\RestFul\Ret\RetInterface;
use App\Http\Requests\AuthAdminIndexRequest;
use App\Http\Requests\AuthAdminSaveRequest;
use App\Http\Requests\IDsRequest;
use App\Lib\RetJson;
use App\Repositories\AuthAccess;
use App\Repositories\AuthAdmin;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class AdminService extends Auth
{

    /**
     * 获取当前管理员信息
     */
    public function getUserInfo(): RetInterface
    {
        //拿到用户信息
        $adminInfo = AuthAdmin::singleton('id', 'username', 'nickname', 'avatar', 'email')
            ->getAdminById(REQUEST_UID)->toArray();
        $groups = $this->getUserGroup(REQUEST_UID);
        $adminInfo['roles'] = array_column($groups->toarray(), 'name');
        // $adminInfo['name'] = [];
        // foreach ($groups as $_group) {
        //     $adminInfo['name'][] = $_group->name;
        // }
        return RetJson::pure()->entity($adminInfo);
    }
    /**
     * 权限管理-管理员-列表获取(需要加上组表里面的角色名字)
     *
     * @param Request $request
     * @return PsrResponseInterface
     */
    public function getAdminList(AuthAdminIndexRequest $request): RetInterface
    {
        // 1--获取下级用户的ID
        $subAllUids = $this->getSubUserIds(REQUEST_UID);
        //用下级用户的ID来查询相应的ID对应的信息，最后用数组保存
        $subUser = AuthAdmin::singleton('id', 'username', 'nickname', 'avatar', 'email')
            ->getAdminByIds($subAllUids)->toArray();
        //下级用户所对应的组，用数组保存
        $groups = $this->getGroups($subAllUids)->toArray();
        //
        $access = $this->getGroupAccessByKey($subAllUids);
        //将需要的数据拼接成需要的格式
        $subUser = array_column($subUser, null, 'id');
        $groups = array_column($groups, null, 'id');
        foreach ($access as $_acc) {
            if (isset($groups[$_acc['group_id']])) {
                $subUser[$_acc['uid']]['name'] = $groups[$_acc['group_id']]['name'];
            }
        }
        return RetJson::pure()->list(array_values($subUser));
    }

    /**
     * 权限管理-管理员-增加和修改
     *
     * @param Request $request
     * @return RetInterface
     */
    public function saveAdmin(AuthAdminSaveRequest $request): RetInterface
    {
        /**
         * 1--拿到当前用户的UID\
         * 2--得到这个UID用户的所有下属的组ID
         * 3--验证添加信息里面的组ID是否属于当前UID用户管
         * 4--提示信息或者入库
         */
        $post = $request->only(array_keys($request->rules()));
        $groupId = [(int)$post['group_id']];
        // $uid = empty($post['id']) ? 0 : (int)$post['id'];
        unset($post['id'], $post['group_id']);

        if ($this->hasUserGroup(REQUEST_UID, $groupId, true)) {
            $user = AuthAdmin::singleton('id')->getAdminByUserName($post['username']);
            if (empty($user)) {
                $post['password'] = encrypt($post['password']);
                DB::beginTransaction();
                try {
                    $uid = AuthAdmin::singleton()->insertGetId($post);
                    // TODO
                    $access = [];
                    foreach ($groupId as $_groupId) {
                        $access[] = [
                            'uid' => $uid,
                            'group_id' => $_groupId
                        ];
                    }
                    AuthAccess::singleton()->insert($access);
                    DB::commit();
                    return RetJson::pure()->msg('添加成功');
                } catch (\Throwable $th) {
                    dd($th);
                    DB::rollBack();
                    return RetJson::pure()->throwable($th);
                }
            } else {
                return RetJson::pure()->error('用户名已经存在');
            }
        } else {
            return RetJson::pure()->error('无权限');
        }
    }

    /**
     * 权限管理-管理员-删除,支持多个
     *
     * @param Request $request
     * @return PsrResponseInterface
     */
    public function deleteAdmin(IDsRequest $request): RetInterface
    {
        $subUids = $request->input('ids');
        //拿到要删除管理员的ID 可以是多个
        if ($this->hasUser(REQUEST_UID, $subUids)) {
            foreach ($subUids as $_subId) {
                $subSubUser = $this->getSubUserIds($_subId);
                // dd($subSubUser);
                if (!empty($subSubUser)) {
                    return RetJson::pure()->error($_subId . '下面还有人，不能删除');
                }
            }
            DB::beginTransaction();
            try {
                AuthAdmin::singleton()->deleteAdminByIds($subUids);
                AuthAccess::singleton()->deleteAccessByUids($subUids);
                DB::commit();
                return RetJson::pure()->msg('删除成功');
            } catch (\Throwable $th) {
                DB::rollBack();
                return RetJson::pure()->throwable($th);
            }
        } else {
            return RetJson::pure()->error('这些人都不是你手下的人');
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
