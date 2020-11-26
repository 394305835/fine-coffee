<?php

namespace App\Http\Services\User;

use App\Contracts\RestFul\Ret\RetInterface;
use App\Http\Requests\SMSRequest;
use App\Lib\Constans;
use App\Lib\File\AdminTheme;
use App\Lib\File\FilePath;
use App\Lib\File\FileService;
use App\Lib\File\UserTheme;
use App\Lib\RetJson;
use App\Repositories\AuthAdmin;
use App\Repositories\SMS;
use App\Repositories\User;
use GuzzleHttp\Client;
use Illuminate\Http\Request;
use Illuminate\Routing\Route;
use Illuminate\Support\Facades\URL;

/**
 * 验证码
 */
class ApiService extends UserBaseService
{
    /**
     * 验证码
     */
    public function sendSMS(SMSRequest $request)
    {
        // 1--拿到电话号码->redis 看哈过期没得 有没有用
        // 2--查询出来有，直接返回验证码，如果没有那么就请求验证码接口地址
        // 3--拿到验证码，放到redis中去。然后保存起来返回.
        $phone = $request->input('phone');
        $code = SMS::singleton()->getSMS($phone);
        if ($code) {
            return RetJson::pure()->entity($code);
        }
        dd(1);
        $client = new Client();
        try {
            //发送
            $res = $client->request('GET', 'http://203.195.206.192:8082/api/sms?phone=' . $phone);
            //响应回来--字符串流  需要转换
            $entity = (string) $res->getBody();
            //json字符串解码，转换成对象
            $entity = json_decode($entity);
            //取到code（验证码的值）
            $code = $entity->entity->code;
            //添加到redis数据库中去 第三个是时间参数.
            SMS::singleton()->create($phone, $code, Constans::TIME_HOUR);
            return RetJson::pure()->entity($code);
        } catch (\Throwable $th) {
            return RetJson::pure()->error('网络错误');
        }
    }

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
        $fs = new UserTheme();
        if (empty($file) || !$fs->verifFile($file)) {
            return RetJson::pure()->msg('请上传图片');
        }
        // 3. 将文件保存到服务器上
        // 4. 得到该文件在服务器上的相对路径
        $filePath = $fs->setFilanme(USER_UID)->upload($file);
        // 5. 将该相对路径保存到用户的使用字段里面去
        AuthAdmin::singleton()->updateById(USER_UID, ['theme' => $filePath->getPath()]);
        // 6. 返回提示信息或者文件相对路径
        return RetJson::pure()->entity($filePath->getUrl());
    }
}
