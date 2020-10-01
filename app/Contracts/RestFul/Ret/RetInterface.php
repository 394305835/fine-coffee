<?php

namespace App\Contracts\RestFul\Ret;

use Illuminate\Contracts\Support\Arrayable;

/**
 * 响应内容的格式
 * 
 * 所有有关 api 响应内容的数据都应该遵守该接口
 */
interface RetInterface extends Arrayable
{
    /**
     * 获取 HTTP 状态码
     *
     * @return integer
     */
    public function getStatusCode(): int;

    /**
     * 获取HTTP响应头信息
     *
     * @param string $key
     * @return array|mixed
     */
    public function getHeaders($key = '');

    /**
     * 获取HTTP响应内容
     *
     * @param mixed $body
     * @return mixed
     */
    public function getBody();
}
