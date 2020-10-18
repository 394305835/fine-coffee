<?php

namespace App\Repositories;

use App\Lib\Repository\RedisRepository;

/**
 * 用户商品下单前的商品 token
 * 
 * PS:用户下单前必须要该 token 
 */
class GoodsToken extends RedisRepository
{
    /**
     * 订单下单token 键key
     *
     * @var string
     */
    protected $key = 'finecoffee:goods:user:token';

    public function __construct()
    {
        parent::__construct();
    }

    /**
     * 创建一个用户对应的商品 token
     *
     * @param integer $userId
     * @param integer $goodsId
     * @return string
     */
    public function create(int $userId, int $goodsId): string
    {
        //创建之前先删除因为38排
        $this->remove($userId, $goodsId);
        $token = $this->createToken($userId, $goodsId);
        // hset这个方法不会覆盖旧值，只会旧值覆盖新值
        $res = $this->redis->hset($this->getKey($userId), $goodsId, $token);
        return $res ? $token : '';
    }

    /**
     * 获取用户对应商品的 token
     *
     * @param integer $userId
     * @param integer $goodsId
     * @return string|null
     */
    public function getToken(int $userId, int $goodsId): ?string
    {
        return $this->redis->hget($this->getKey($userId), $goodsId);
    }

    /**
     * 删除用户对应商品的 token 
     *
     * @param integer $userId
     * @param integer $goodsId
     * @return boolean
     */
    public function remove(int $userId, int $goodsId): bool
    {
        return !!$this->redis->hdel($this->getKey($userId), $goodsId);
    }

    /**
     * 判断商品 token 是否在正确
     *
     * @param integer $userId
     * @param integer $goodsId
     * @return boolean
     */
    public function checkToken(int $userId, int $goodsId, string $token): bool
    {
        $_token = $this->getToken($userId, $goodsId);
        return $_token ? $_token === $token : false;
    }


    /**
     * 创建一个Token
     *
     * @param integer $userId
     * @param integer $goodsId
     * @return string
     */
    protected function createToken(int $userId, int $goodsId): string
    {
        return md5(time() . $userId . $goodsId);
    }
}
