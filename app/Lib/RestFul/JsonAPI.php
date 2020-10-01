<?php

namespace App\Lib\RestFul;

use App\Contracts\RestFul\RESTFulAPI;
use App\Contracts\RestFul\Ret\RetInterface;

/**
 * JSON 格式的 RESTFul API 风格
 * 
 */
class JsonAPI implements RESTFulAPI
{
    /**
     * 常规响应，即没有内容的响应
     * 
     * ```json
     * {
     *   'code': 200
     *   // ...
     * }
     * ```
     *
     * @return void
     */
    public function reply(RetInterface $ret, int $statusCode = 200, array $header = [])
    {
        // 优先使用 ret 的状态码
        if ($statusCode != $ret->getStatusCode()) {
            $statusCode = $ret->getStatusCode();
        }
        return response()->json($ret(), $statusCode, $header);
    }

    /**
     * 实体响应，即响应实体数据
     * 
     * ```json
     * {
     *   'code' : 200,
     *   'entity' : {
     *     'id': 1,
     *     'age': 20,
     *     // ...
     *   }
     * }
     * ```
     *
     * @return void
     */
    public function replyEntity(array $entity)
    {
    }


    /**
     * 集合响应，即响应列表型数据
     * ```json
     * {
     *   'code' : 200,
     *   'list' : [
     *     {'id': 1, 'username': 'Withe'},
     *     {'id': 2, 'username': 'Black'},
     *     // ...
     *   ]
     * }
     * ```
     * @return void
     */
    public function replyList(array $list)
    {
    }
}
