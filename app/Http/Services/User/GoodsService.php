<?php

namespace App\Http\Services\User;

use App\Contracts\RestFul\Ret\RetInterface;
use App\Lib\RetJson;

/**
 * 该类提供了用户端的商品类
 */
class GoodsService
{

    /**
     * 改方法提供了用户端商品的查询接口
     *
     * @param [type] $request
     * @return RetInterface
     */
    public function getGoodsList($request): RetInterface
    {
        return RetJson::pure()->msg('成功');
    }
}
