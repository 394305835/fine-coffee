<?php

namespace App\Model\Mysql;


/**
 * 商品属性表 规格，温度，糖，奶油，加料
 * 
 * @property int $id 规格标签名
 * @property int $created_at   
 * @property int $updated_at   
 * 
 * ```sql
 *CREATE TABLE `fc_goods_section` (
 *`id` int(11) unsigned NOT NULL AUTO_INCREMENT,
 *`title` varchar(5) CHARACTER SET utf8 COLLATE utf8_general_ci DEFAULT NULL COMMENT '商品规格标签名（规格，温度，糖，奶油，加料）',
 *`created_at` int(11) DEFAULT NULL,
 *`updated_at` int(11) DEFAULT NULL,
 *PRIMARY KEY (`id`)
 * ENGINE=MyISAM AUTO_INCREMENT=8 DEFAULT CHARSET=utf8 COMMENT='商品详情 规格，温度，糖，奶油，加料';
 * ```
 */
class GoodsSectionModel extends Model
{
    protected $table = 'goods_section';

    protected $attributes = [
        'id',
        'title',
        'created_at',
        'updated_at'
    ];
}
