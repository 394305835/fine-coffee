<?php

namespace App\Model\Mysql;


/**
 * 商品分类模型表
 * 

 * @property int $goods_id 商品ID
 * @property int $category_id 分类ID
 * 
 * ```sql
 * CREATE TABLE `fc_goods_category_access` (
 *   `goods_id` int(11) unsigned DEFAULT '0' COMMENT '商品ID',
 *   `category_id` int(11) unsigned DEFAULT '0' COMMENT '分类ID',
 *   UNIQUE KEY `goods_id` (`goods_id`,`category_id`)
 * ) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='商品与分类关系';
 * ```
 */
class GoodsCategoryAccessModel extends Model
{
    protected $table = 'goods_category_access';

    protected $attributes = [
        'id',
        'value',
    ];
}
