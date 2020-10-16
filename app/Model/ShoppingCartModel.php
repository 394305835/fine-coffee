<?php

namespace App\Model;

/**
 * 购物车数据模型
 */
class ShoppingCartModel
{
    /**
     * 购物车ID
     *
     * @var string
     */

    public $uuid;
    /**
     * 用户ID
     *
     * @var int
     */
    public $user_id;

    /**
     * 商品ID
     *
     * @var int
     */
    public $goods_id;

    /**
     * 订单表主ID
     *
     * @var int
     */
    public $order_id;

    /**
     * 购买商品数量
     *
     * @var int
     */
    public $number;

    /**
     * 订单创建时间
     *
     * @var int
     */
    public $begin_time;

    /**
     * 订单结束时间
     *
     * @var int
     */
    public $end_time;

    /**
     * 商品总价
     *
     * @var string
     */
    public $price;

    /**
     * 商品属性选择title
     *
     * @var array
     */
    public $type_title;

    /**
     * 商品属性选择
     *
     * PS:记录商品属性选择--ID
     * @var array
     */
    public $type_id;


    /**
     * 生成购物车唯一的key
     *
     * @param integer $uid
     * @param integer $goodsId
     * @param array $typeId
     * @return string
     */
    public function createUUID(int $uid, int $goodsId, array $typeId): string
    {
        //PHP提供的排序方法，属于内排，无返回值。直接取地址操作的。
        sort($typeId);
        $typeId = implode(',', $typeId);
        return md5($uid . $goodsId . $typeId);
    }
}
