<?php

namespace App\Repositories\User;

use App\Model\DShoppingCartModel;

/**
 * 用户的购物车仓库
 * 
 * 数据模型遵守 `DShoppingCartModel`
 */
class ShoppingCart extends UserRedis
{

    public function __construct(int $user_id)
    {
        $this->concatTplKey('shop');
        parent::__construct($user_id);
    }

    /**
     * 创建一辆购物车
     *
     * @param DShoppingCartModel $cart
     * @return boolean
     */
    public function create(DShoppingCartModel $cart): bool
    {
        return $this->redis->hset($this->key, $cart->cart_id, serialize($cart));
    }

    public function remove(string $cart_id)
    {
        return $this->redis->hdel($this->key, $cart_id);
    }

    /**
     * 累加购物车数量
     * 
     * @param string $cart_id
     * @param integer $times
     * @return boolean
     */
    public function incrementNumber(string $cart_id, int $times): bool
    {
        $oldShop = $this->getShopById($cart_id);
        if ($oldShop) {
            $oldShop->number += $times;
            return $this->create($oldShop);
        }
        return false;
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
