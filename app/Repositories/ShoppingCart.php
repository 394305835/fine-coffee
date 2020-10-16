<?php

namespace App\Repositories;

use App\Lib\Repository\RedisRepository;
use App\Model\ShoppingCartModel;

/**
 * 购物车仓库
 */
class ShoppingCart extends RedisRepository
{

    /**
     * 订单下单token 键key
     *
     * @var string
     */
    protected $key = 'finecoffee:goods:shoppingcart';


    public function __construct()
    {
        parent::__construct();
    }

    /**
     * 获取用户对应购物车的redis   key
     *
     * @param integer $uid
     * @return string
     */
    public function getRedisKey(int $uid): string
    {
        return $this->getKey($uid);
    }

    /**
     * 创建一辆购物车
     *
     * @param ShoppingCartModel $cart
     * @return boolean
     */
    public function create(ShoppingCartModel $cart): bool
    {
        // $cartKey = $this->getCartKey($cart->user_id, $cart->goods_id, $cart->type_id);
        $redisKey = $this->getRedisKey($cart->user_id);
        return $this->redis->hset($redisKey, $cart->uuid, serialize($cart));
    }
}
