<?php

namespace App\Model;


/**
 * 
 * @property string $uuid      订单全球唯一ID
 * @property int $seller_id 商家唯一ID
 * @property int $user_id   用户唯一ID
 * @property int $pay_id   支付ID
 * @property int $place   订单生成时间,也就是当用户点击进入支付页面开始算起
 * @property int $etime   订单到期时间
 * @property int $status  订单状态,默认状态为1正常
 * @property DShoppingCartModel|DShoppingCartModel[] $shopcart   购物车信息,一条订单可多个购物车(array)
 * 
 * 
 * 队列订单模型
 * 
 * 主要以用户与商家相关
 * 
 */
class DOrdereModel
{

    /**
     * 订单全球唯一ID
     * 
     * @var string
     */
    public $uuid;

    /**
     *  商家唯一ID
     * 
     * @var int
     */
    public $seller_id;

    /**
     * 用户唯一ID
     * 
     * @var int
     */
    public $user_id;

    /**
     * 支付ID
     *
     * @var int
     */
    public $pay_id;

    /**
     * 订单生成时间,也就是当用户点击进入支付页面开始算起
     * 
     * @var int
     */
    public $place;

    /**
     * 订单过期时间
     *
     * @var int
     */
    public $etime;

    /**
     * 订单状态,默认状态为1正常
     * 
     * @var int
     */
    public $status = 1;


    /**
     * redis 保存的唯一key，为了防止同
     *
     * @var string
     */
    public $redis_key;

    /**
     * 订单创建时间，也就是被该记录被创建出来的时间
     * 
     * @var int
     */
    protected $created_at;


    /**
     * 订单总价
     *
     * @var float
     */
    public $total_price;

    public function __construct(
        string $uuid,
        int $seller_id,
        int $user_id,
        int $place,
        int $etime,
        float $totalPrice

    ) {
        $this->uuid = $uuid;
        $this->seller_id = $seller_id;
        $this->user_id = $user_id;
        $this->place = $place;
        $this->etime = $etime;
        $this->total_price = $totalPrice;

        $this->created_at = time();
    }
}
