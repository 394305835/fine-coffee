<?php

namespace App\Http\Services\User;

use App\Http\Requests\SMSRequest;
use App\Lib\Constans;
use App\Lib\RetJson;
use App\Repositories\SMS;
use GuzzleHttp\Client;

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
}
