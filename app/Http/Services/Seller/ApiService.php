<?php

namespace App\Http\Services\Seller;

use App\Contracts\RestFul\Ret\RetInterface;
use App\Lib\File\SellerTheme;
use App\Lib\RetJson;
use App\Repositories\Seller;
use Illuminate\Http\Request;

/**
 * 验证码
 */
class ApiService
{
    /**
     * 修改用户头像
     * @param Request $request
     * @return RetInterface
     */
    public function saveUserTheme(Request $request): RetInterface
    {
        // 1. 接受到文件
        $file = $request->file('theme');
        // 2. 验证文件是否有有效
        $fs = new SellerTheme();
        if (empty($file) || !$fs->verifFile($file)) {
            return RetJson::pure()->msg('请上传图片');
        }

        // 3. 将文件保存到服务器上
        // 4. 得到该文件在服务器上的相对路径
        $filePath = $fs->setFilanme(SELLER_UID)->upload($file);
        // 5. 将该相对路径保存到用户的使用字段里面去
        Seller::singleton()->updateById(SELLER_UID, ['theme' => $filePath->getPath()]);
        // 6. 返回提示信息或者文件相对路径
        return RetJson::pure()->entity($filePath->getUrl());
    }
}
