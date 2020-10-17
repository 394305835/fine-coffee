<?php

namespace App\Model\Mysql;


/**
 * 订单模型
 * 
 * @property int $id
 * @property string $uuid 订单全球唯一ID
 * @property int $seller_id  商家ID
 * @property string $cart_id 购物车ID
 * @property int $user_id NUL'用户ID
 * @property int $goods_id NUL'商品ID
 * @property int $lable_id NUL'分类ID（人气TOP，中秋限定，厚乳拿铁，经典拿铁）
 * @property int $pay_id NULL DEFAULT '0'支付方式ID
 * @property string $sections 规格选配（大，小，冷，热，无糖）
 * @property int $pay_status 支付状态  0 未支付 1取消支付 2订单过期 3支付成功
 * @property int $status 订单状态 0 删除 1正常
 * @property int $place_time 订单创建时间，并非订单这条记录生成时间
 * @property int $pay_time 支付时间
 * @property int $created_at 
 * @property int $updated_at 
 * 
 * ```sql
 * CREATE TABLE `fc_order` (
 * `id` int(11) unsigned NOT NULL DEFAULT '0',
 * `uuid` varchar(255) NOT NULL DEFAULT '' COMMENT '订单全球唯一ID',
 * `seller_id` int(11) NOT NULL DEFAULT '0' COMMENT '商家ID',
 * `cart_id` varchar(255) NOT NULL DEFAULT '' COMMENT '购物车ID',
 * `user_id` int(11) unsigned NOT NULL COMMENT '用户ID',
 * `goods_id` int(11) unsigned NOT NULL COMMENT '商品ID',
 * `lable_id` int(11) unsigned NOT NULL COMMENT '分类ID（人气TOP，中秋限定，厚乳拿铁，经典拿铁）',
 * `pay_id` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '支付方式ID',
 * `sections` varchar(11) DEFAULT '0' COMMENT '规格选配（大，小，冷，热，无糖）',
 * `pay_status` tinyint(3) unsigned DEFAULT '0' COMMENT '支付状态  0 未支付 1取消支付 2订单过期 3支付成功',
 * `status` tinyint(1) unsigned DEFAULT '1' COMMENT '订单状态 0 删除 1正常',
 * `place_time` int(11) unsigned DEFAULT NULL COMMENT '订单创建时间，并非订单这条记录生成时间',
 * `pay_time` int(11) unsigned DEFAULT NULL COMMENT '支付时间',
 * `created_at` int(11) DEFAULT NULL,
 * `updated_at` int(11) DEFAULT NULL,
 * PRIMARY KEY (`id`)
 * ) ENGINE=InnoDB DEFAULT CHARSET=utf8;
 * ```
 */
class OrderModel extends Model
{
    protected $table = 'order';

    protected $attributes = [
        'id',
        'uuid',
        'seller_id',
        'cart_id',
        'user_id',
        'goods_id',
        'lable_id',
        'pay_id',
        'sections',
        'status',
        'place_time',
        'pay_time',
        'created_at',
        'updated_at',
    ];
}
