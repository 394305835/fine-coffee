<?php

namespace App\Model;

use App\Lib\Constans;

/**
 * 
 * @property string $cart_id  购物车ID, 该 uuid 标识的是 用户+商品+商品属性的唯一性
 * @property int $user_id  用户ID
 * @property int $goods_id 商品ID
 * @property array $type_id      商品属性ID
 * @property string $type_title   商品属性文字
 * @property int $number   商品数量，单个商品数量不能超过 Constans::GOODS_SHOP_MAX_NUMBER
 * @property int $btime    创建的开始时间
 * @property int $etime    结束时间，也就是购物车从创建开始后多久过期
 * @property int|float $price    商品单位
 * @property int|float $discount 商品折扣价格,也就是优惠了多少钱
 * @property int|float $discount_price 商品折扣金额,也就是优惠会的商品单价
 * @property int|float $actual   实际应支付
 * @property string $gid   购物车商品 token
 * 
 * @method string createUUID(int $uid, int $goodsId, array $typeId)
 * 
 * 
 * 购物车数据模型
 * 
 * 数据主要以商品相关
 * 
 */
class DShoppingCartModel
{
    /**
     * 购物车ID
     *
     * @var string
     */
    public $cart_id;

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
     * 购物车商品 token
     *
     * @var string
     */
    public $gid;

    /**
     * 购买商品数量
     *
     * @var int
     */
    public $number;

    /**
     * 商品单价
     *
     * @var int|float
     */
    public $price;

    /**
     * 商品折扣价格,也就是优惠了多少钱
     *
     * @var int|float
     */
    public $discount;

    /**
     * 商品折扣金额,也就是优惠会的商品单价
     *
     * @var int|float
     */
    public $discount_price;

    /**
     * 实际应支付
     *
     * @var int|float
     */
    public $actual;

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
     * 创建的开始时间
     *
     * @var int
     */
    public $btime;

    /**
     * 结束时间，也就是购物车从创建开始后多久过期
     *
     * @var int
     */
    public $etime;

    public function __construct(
        int $userId,
        int $goodsId,
        array $typeId,
        string $type_title,
        int $number,
        int $price,
        int $discount,
        int $discount_price,
        int $actual,
        string $gid = ""
    ) {
        $this->cart_id = $this->createUUID($userId, $goodsId, $typeId);
        $this->type_title = $type_title;
        $this->number = $number;
        $this->price = $price;
        $this->gid = $gid;
        $this->discount = $discount;
        $this->discount_price = $discount_price;
        $this->actual = $actual;

        $this->btime = time();
        // 购物车过期时间
        $this->etime = $this->btime + Constans::TIME_HOUR;
    }

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
        $this->user_id = $uid;
        $this->goods_id = $goodsId;
        // NOTE: 将 type_id 从小到大依次排序，为了区分 用户+商品+商品属性的唯一性
        //PHP提供的排序方法，属于内排，无返回值。直接取地址操作的。
        sort($typeId);
        $this->type_id = implode(',', $typeId);

        return md5($uid . $goodsId . $this->type_id);
    }
}
