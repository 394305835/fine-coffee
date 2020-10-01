<?php

namespace App\Lib\RestFul;

use App\Contracts\RestFul\RESTFulAPI;
use App\Contracts\RestFul\Ret\RetInterface;

/**
 * XML 格式的 RESTFul API 风格
 * 
 */
abstract class XmlAPI implements RESTFulAPI
{
    /**
     * 常规响应，即没有内容的响应
     * 
     * @return void
     */
    abstract public function reply(RetInterface $ret);

    /**
     * 实体响应，即响应实体数据
     * 
     * @return void
     */
    abstract public function replyByEntity();


    /**
     * 集合响应，即响应列表型数据
     * 
     * @return void
     */
    abstract public function replyByList();
}
