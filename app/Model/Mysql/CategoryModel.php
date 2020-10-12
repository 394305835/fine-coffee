<?php

namespace App\Model\Mysql;


/**
 * 商品类别模型表
 * 
 * ```sql
 * CREATE TABLE `fc_goods_category` (
 *`id` int(11) unsigned NOT NULL AUTO_INCREMENT,
 *`title` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci DEFAULT NULL COMMENT '商品类别名称',
 *`sort` tinyint(11) DEFAULT NULL COMMENT '排序',
 *`created_at` int(11) DEFAULT NULL,
 *`updated_at` int(11) DEFAULT NULL,
 *PRIMARY KEY (`id`) USING BTREE
 *) ENGINE=MyISAM AUTO_INCREMENT=10 DEFAULT CHARSET=utf8 COMMENT='商品类别表--人气top--厚乳拿铁--大师咖啡--经典拿铁';
 * ```
 */
class CategoryModel extends Model
{
    protected $table = 'goods_category';

    protected $attributes = [
        'id',
        'title',
        'sort',
        'created_at',
        'updated_at',
    ];
}
