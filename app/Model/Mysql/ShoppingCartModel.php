<?php

namespace App\Model\Mysql;


/**
 * 购物车模型
 * 
 *@property int $uuid 过期时间
 *@property int $user_id 用户ID
 *@property int $goods_id 商品ID
 *@property int $number 数量
 *@property int $begin_time 开始时间
 *@property int $end_time 过期时间
 *@property float $price COMMENT 单价
 * 
 * ```sql
 *CREATE TABLE `redis_shoppingcart` (
 *  `uuid` int(11) NOT NULL COMMENT '过期时间',
 *  `user_id` int(11) NOT NULL COMMENT '用户ID',
 *  `goods_id` int(11) NOT NULL COMMENT '商品ID',
 *  `number` int(11) NOT NULL COMMENT '数量',
 *  `begin_time` int(11) NOT NULL COMMENT '开始时间',
 *  `end_time` int(11) NOT NULL COMMENT '过期时间',
 *  `price` decimal(11,4) NOT NULL COMMENT '单价',
 *  PRIMARY KEY (`uuid`) USING BTREE
 *) ENGINE=MyISAM DEFAULT CHARSET=utf8;
 * ```
 */
class ShoppingCartModel
{
}
