<?php

namespace App\Repositories;

use App\Contracts\Repositories\RedisTokenInterface;
use App\Lib\Repository\RedisRepository;

/**
 * token 放在 普通 key 里面,可以保证期时间有效性
 */
class OrderToken extends RedisRepository
{
    /**
     * 订单下单token 键key
     *
     * @var string
     */
    protected $key = 'finecoffee:goods:order:token';


    public function __construct()
    {
        parent::__construct();
    }

    /**
     * 创建一个token key=>value
     *
     * @param string $key
     * @param string $value
     * @return boolean
     */
    public function create(string $key, string $value): bool
    {
        return $this->redis->hset($this->key, $key, $value);
    }

    /**
     * 获取指定key值的token
     *
     * @param string $key
     * @return string
     */
    public function getToken(string $key): string
    {
        return $this->redis->hget($this->key, $key);
    }
    /**
     * 删除key值所对应的Token
     *
     * @param string $key
     * @return boolean
     */
    public function remove(string $key): bool
    {
        return $this->redis->hdel($this->key, $key);
    }

    /**
     * 判断$key在hash表中是否存在
     *
     * @param string $key
     * @return boolean
     */
    public function hasKey(string $key): bool
    {
        return $this->redis->hexists($this->key, $key);
    }
}
