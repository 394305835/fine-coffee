<?php

namespace App\Model;


class DTokenInfo
{
    /**
     * 当前 token 信息类型.
     * 
     * 可以是: apiKey
     *
     * @var string
     */
    public $type;

    /**
     * 表示当前token是否重复被创建
     *
     * @var bool
     */
    public $repeat;

    /**
     * token 存在的 key 值
     *
     * 可以是任意字符串
     * 
     * @var string
     */
    public $key;

    /**
     * 是否被弃用
     *
     * @var bool
     */
    public $void;

    /**
     * 创建的token值
     *
     * @var string
     */
    public $token;

    public function __construct(
        string $key = 'Authorization',
        string $token = '',
        string $type = 'apiKey',
        bool $repeat = false,
        bool $void = false
    ) {
        $this->key = $key;
        $this->token = $token;
        $this->type = $type;
        $this->repeat = $repeat;
        $this->void = $void;
    }
}
