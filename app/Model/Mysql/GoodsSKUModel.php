<?php

namespace App\Model\Mysql;


/**
 * 商品库存
 * 
 *@property int goods_id
 *@property int sku
 *@property int created_at
 *@property int updated_at
 * 
 * ```sql
 * CREATE TABLE `fc_goods_sku` (
 *   `goods_id` int(11) unsigned NOT NULL DEFAULT '0',
 *   `sku` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '商品的库存数量，最小0',
 *   `created_at` int(11) DEFAULT NULL,
 *   `updated_at` int(11) DEFAULT NULL,
 *   PRIMARY KEY (`goods_id`),
 *   KEY `sku` (`sku`)
 * ) ENGINE=MyISAM DEFAULT CHARSET=utf8 COMMENT='商品库存';
 * ```
 */
class GoodsSKUModel extends Model
{
    protected $table = 'goods_sku';

    protected $attributes = [
        'goods_id',
        'sku',
        'created_at',
        'updated_at',
    ];
}
