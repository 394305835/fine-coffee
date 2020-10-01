<?php

namespace App\Model\Mysql;


/**
 * 订单模型
 * 
 *@property int user_id  用户ID
 *@property int goods_id  商品ID
 *@property int lable_id  分类ID（人气TOP，中秋限定，厚乳拿铁，经典拿铁）
 *@property int pay_id 
 *@property int sections  规格选配（大，小，冷，热，无糖）
 *@property int created_at 
 *@property int updated_at 
 * 
 * ```sql
 *CREATE TABLE `fc_order` (
 * `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
 * `user_id` int(11) unsigned NOT NULL COMMENT '用户ID',
 * `goods_id` int(11) unsigned NOT NULL COMMENT '商品ID',
 * `lable_id` int(11) unsigned NOT NULL COMMENT '分类ID（人气TOP，中秋限定，厚乳拿铁，经典拿铁）',
 * `pay_id` int(11) NOT NULL COMMENT '支付方式ID',
 * `sections` int(11) unsigned NOT NULL COMMENT '规格选配（大，小，冷，热，无糖）',
 * `created_at` int(11) DEFAULT NULL,
 * `updated_at` int(11) DEFAULT NULL,
 * PRIMARY KEY (`id`)
 *) ENGINE=MyISAM DEFAULT CHARSET=utf8;
 * ```
 */
class OrderModel extends Model
{
    protected $table = 'order';

    protected $attributes = [
        'id',
        'user_id',
        'goods_id',
        'lable_id',
        'pay_id',
        'sections',
        'created_at',
        'updated_at',
    ];
}
