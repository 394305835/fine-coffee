<?php


namespace App\Http\Services\AuthService;

use App\Http\Requests\AuthAdminSaveRequest;
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
    }

    /**
     * 权限管理-角色组-增加
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
