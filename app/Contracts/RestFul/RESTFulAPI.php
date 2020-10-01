<?php

namespace App\Contracts\RestFul;

use App\Contracts\RestFul\Ret\RetInterface;

/**
 * RESTFul 风格型 API 返回
 * 
 * 所有有关 api 响应内容都应该遵守该接口
 */
interface RESTFulAPI
{
    /**
     * 常规响应，即没有内容的响应
     *
     * @return void
     */
    public function reply(RetInterface $ret);
}
