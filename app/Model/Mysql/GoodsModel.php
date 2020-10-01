<?php

namespace App\Model\Mysql;


/**
 * 商品模型
 * 
 *@property int $id
 *@property int $lable_id 商品标签ID
 *@property string $theme 商品展示图片
 *@property string $name  商品名称
 *@property string $subtitle 商品英文名
 *@property float $price 商品售价
 *@property string $details 商品详情
 *@property string $sections 选配规格ID集合,已逗号分开
 *@property int $is_sale 表示是否在售  1:表示再卖  0：售空
 *@property int $created_at 
 *@property int $updated_at 
 * 
 * ```sql
 * CREATE TABLE `fc_goods` (
 *  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
 *  `lable_id` int(11) NOT NULL COMMENT '商品标签ID',
 *  `theme` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci DEFAULT NULL COMMENT '商品展示图片',
 *  `name` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL COMMENT '商品名称',
 *  `subtitle` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL COMMENT '商品英文名',
 *  `price` decimal(10,4) NOT NULL COMMENT '商品售价',
 *  `details` text COMMENT '商品详情',
 *  `sections` varchar(50) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL COMMENT '选配规格ID集合,已逗号分开',
 *  `is_sale` tinyint(1) NOT NULL COMMENT '表示是否在售  1:表示再卖  0：售空',
 *  `created_at` int(11) DEFAULT NULL,
 *  `updated_at` int(11) DEFAULT NULL,
 *  PRIMARY KEY (`id`)
 * ) ENGINE=MyISAM DEFAULT CHARSET=utf8;
 * ```
 */
class GoodsModel extends Model
{
    protected $table = 'goods';

    protected $attributes = [
        'id',
        'lable_id',
        'theme',
        'name',
        'subtitle',
        'price',
        'details',
        'sections',
        'is_sale',
        'created_at',
        'updated_at'
    ];
}
