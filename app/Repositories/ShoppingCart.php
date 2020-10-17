<?php

namespace App\Repositories;

use App\Lib\Repository\RedisRepository;
use App\Model\DShoppingCartModel;

/**
 * 购物车仓库
 */
class ShoppingCart extends RedisRepository
{

    /**
     * 用户购物车信息 key
     *
     * @var string
     */
    protected $key = 'finecoffee:goods:user:shop';

    public function __construct(int $user_id)
    {
        parent::__construct();
        $this->key = $this->getKey($user_id);
    }

    /**
     * 获取用户对应购物车的redis key
     *
     * @param integer $uid
     * @return string
     */
    public function getRedisKey(int $uid): string
    {
        // return $this->getKey($uid);
        return $this->key;
    }

    /**
     * 创建一辆购物车
     *
     * @param DShoppingCartModel $cart
     * @return boolean
     */
    public function create(DShoppingCartModel $cart): bool
    {
        // $cartKey = $this->getCartKey($cart->user_id, $cart->goods_id, $cart->type_id);
        return $this->redis->hset($this->key, $cart->cart_id, serialize($cart));
    }

    public function remove(string $cart_id)
    {
        return $this->redis->hdel($this->key, $cart_id);
    }

    /**
     * 用购物车ID 获取一条购物车信息
     * 
     * @param string $cart_id
     * @return DShoppingCartModel|null
     */
    public function getShopById(string $cart_id): ?DShoppingCartModel
    {
        $shop = $this->redis->hget($this->key, $cart_id);
        return $shop ? unserialize($shop) : null;
    }
}
