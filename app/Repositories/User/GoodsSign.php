<?php

namespace App\Repositories\User;

/**
 * 用户商品下单前的商品 token
 * 
 * PS:用户下单前必须要该 token 
 */
class GoodsSign extends UserRedis
{

    public function __construct(int $user_id)
    {
        $this->concatTplKey('sign');
        parent::__construct($user_id);
    }

    /**
     * 创建一个用户对应的商品 token
     *
     * @param integer $goodsId
     * @return string
     */
    public function create(int $goodsId): string
    {
        //创建之前先删除因为31排
        $this->remove($goodsId);
        $token = $this->createToken($goodsId);
        // hset这个方法不会覆盖旧值，只会旧值覆盖新值
        $res = $this->redis->hset($this->key, $goodsId, $token);
        return $res ? $token : '';
    }

    /**
     * 获取用户对应商品的 token
     *
     * @param integer $userId
     * @param integer $goodsId
     * @return string|null
     */
    public function getToken(int $goodsId): ?string
    {
        return $this->redis->hget($this->key, $goodsId);
    }

    /**
     * 删除用户对应商品的 token 
     *
     * @param integer $goodsId
     * @return boolean
     */
    public function remove(int $goodsId): bool
    {
        return !!$this->redis->hdel($this->key, $goodsId);
    }

    /**
     * 判断商品 token 是否在正确
     *
     * @param integer $goodsId
     * @return boolean
     */
    public function checkToken(int $goodsId, string $token): bool
    {
        $_token = $this->getToken($goodsId);
        return $_token ? $_token === $token : false;
    }


    /**
     * 创建一个Token
     *
     * @param integer $goodsId
     * @return string
     */
    protected function createToken(int $goodsId): string
    {
        return md5(time() . $this->uid . $goodsId);
    }
}
