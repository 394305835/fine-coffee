<?php


namespace App\Http\Services\Admin;

use App\Contracts\RestFul\Ret\RetInterface;
use App\Lib\File\AdminTheme;
use App\Lib\RetJson;
use App\Repositories\AuthAdmin;
use Illuminate\Http\Request;

class ApiService
{

    /**
     * 修改管理员头像
     * @param Request $request
     * @return RetInterface
     */
    public function saveAdminTheme(Request $request): RetInterface
    {
        // 1. 接受到文件
        $file = $request->file('theme');
        // 2. 验证文件是否有有效
        $fs = new AdminTheme();
        if (empty($file) || !$fs->verifFile($file)) {
            return RetJson::pure()->msg('请上传图片');
        }

        // 3. 将文件保存到服务器上
        // 4. 得到该文件在服务器上的相对路径
        $filePath = $fs->setFilanme(REQUEST_UID)->upload($file);
        // 5. 将该相对路径保存到用户的使用字段里面去
        AuthAdmin::singleton()->updateById(REQUEST_UID, ['theme' => $filePath->getPath()]);
        // 6. 返回提示信息或者文件相对路径
        return RetJson::pure()->entity($filePath->getUrl());
    }


    /**
     * 新增管理员头像
     * @param Request $request
     * @return RetInterface
     */
    public function addAdminTheme(Request $request, int $id): RetInterface
    {
        // 1. 接受到文件
        $file = $request->file('theme');
        // 2. 验证文件是否有有效
        $fs = new AdminTheme();
        if (empty($file) || !$fs->verifFile($file)) {
            return RetJson::pure()->msg('请上传图片');
        }

        // 3. 将文件保存到服务器上
        // 4. 得到该文件在服务器上的相对路径
        $filePath = $fs->setFilanme($id)->upload($file);
        // 5. 将该相对路径保存到用户的使用字段里面去
        AuthAdmin::singleton()->updateById($id, ['theme' => $filePath->getPath()]);
        // 6. 返回提示信息或者文件相对路径
        return RetJson::pure()->entity($filePath->getUrl());
    }
}
