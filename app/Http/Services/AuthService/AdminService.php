<?php


namespace App\Http\Services\AuthService;

use App\Http\Requests\AuthAdminSaveRequest;
use App\Http\Requests\IDsRequest;
use App\Lib\Tree;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

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
        $curreatuid = 1;
        //1-获取当前登录用户的角色  当前登录用户uid为2
        $groupId = DB::table('auth_group_access')->where('uid', $curreatuid)->value('group_id');
        dump($groupId); //1
        //2-获取当前登录用户的角色下面的所有角色
        $arr = DB::table('auth_group')->select('id', 'pid', 'name')->get()->toArray();
        // auth_group 表里的数据
        $arr = json_encode($arr);
        $arr = json_decode($arr, true);
        //查询当前登录用户 1 的所属角色 下面的所有角色组group_ID
        $ids = Tree::instance()->getChildren($arr, $groupId);
        //2,3,4,5,6,6,6
        dump($ids);
        //3-获取当前登录用户的角色管理所有用户--uid
        $idcolvalue = array_column($ids, 'id');
        dump($idcolvalue);
        //2,3,4,5,6,7
        // select uid from auth_group_access where group_id in($idcolvalue);
        $uids = DB::table('auth_group_access')->whereIn('group_id', $idcolvalue)->pluck('uid');
        dump($uids);
        $result = DB::table('admin')->whereIn('id', $uids)->get();
        dump($result);
    }

    /**
     * 权限管理-管理员-增加和保存
     *
     * @param Request $request
     * @return PsrResponseInterface
     */
    public function saveAdmin(AuthAdminSaveRequest $request)
    {
        $post = $request->only(array_keys($request->rules()));
        //1-增加验证用户信息是否存在
        $admin = DB::table('admin')->where('username', $post['username'])->first();
        if (isset($admin)) {
            echo '用户名存在';
        } else {
            // 2-增加 验证添加组信息是否是当前登录的这个角色的所属组
            $arr = DB::table('auth_group')->select('id', 'pid')->get()->toArray();
            // $arr = [
            //     ['id' => 1, 'pid' => 0],
            //     ['id' => 2, 'pid' => 1],
            //     ['id' => 3, 'pid' => 1],
            //     ['id' => 4, 'pid' => 2],
            //     ['id' => 5, 'pid' => 4],
            // ];
            $ids = Tree::instance()->getChildren($arr, 2, true);

            //判断获取的当前用户组是否
            if (in_array($post['group_id'], array_column($ids, 'id'))) {
                $uid = DB::table('admin')->insertGetId([
                    'username' => $post['username'],
                    'nickname' => $post['nickname'],
                    'password' => $post['password'],
                    'avater' => $post['avater'],
                    'email' => $post['email']
                ]);
                DB::table('auth_group_access')->insert([
                    'uid' => $uid,
                    'groud_id' => $post['groud_id'],
                ]);
            } else {
                echo '入库失败';
            }
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
        //拿到要删除管理员的ID 可以是多个
        $id = $request->input('ids');
        //验证ID对应的用户是否有权限去删除，其中有一个不是就算失败
        $arr = DB::table('auth_group')->select('id', 'pid')->get()->toArray();
        $arr = json_encode($arr);
        $arr = json_decode($arr, true);
        //查询当前登录用户 2 的所属角色 下面的所有角色组group_ID
        $ids = Tree::instance()->getChildren($arr, 2);
        //查询删除用户所对应的角色组 group_ID
        $userGroup = db::table('auth_group_access')->whereIn('uid', $id)->get()->toArray();
        // echo '查询删除用户所对应的角色组 group_ID';
        // dump($userGroup);
        // dump($userGroup);
        $i = 0;
        //循环
        $groupIds = array_column($ids, 'id');
        // echo '查询当前登录用户 2 的所属角色 下面的所有角色组group_ID,对应的ID';
        // dump($groupIds);

        // 方式1
        // 求所有数组的交集
        $intersect = array_intersect($groupIds, array_column($userGroup, 'group_id'));
        // echo '求交集';
        // dd($intersect);

        //方式2
        //外层循环分别是当前需要删除的用户的ID对应的group_id组
        // foreach ($userGroup as $_userGroup) {
        //     //内层循环则是当前登录用户可以有权限操作的下属的所有group_id组
        //     foreach ($ids as $_id) {
        //         //if判断当前要删除的用户ID对应的组的ID是否是当前登录用户下属的组的ID里面。
        //         if ($_userGroup->group_id === $_id['id']) {
        //             $i++;
        //         }
        //     }
        // }
        if ($i === count($id)) {
            echo 'OK';
        } else {
            echo 'fail';
        }
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
