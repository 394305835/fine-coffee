<?php

namespace App\Model\Mysql;


/**
 *  和商品详情 '属性选择表'   。 大  小   冷   热   糖  半份糖，全糖 
 * 
 * @property int $id 规格标签名
 * @property int $created_at   
 * @property int $updated_at   
 * 
 * ```sql
 *CREATE TABLE `fc_goods_section_type` (
 * `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
 * `title` varchar(5) CHARACTER SET utf8 COLLATE utf8_general_ci DEFAULT NULL COMMENT '商品属性规格名称(规格，温度，糖)',
 * `created_at` int(11) DEFAULT NULL,
 * `updated_at` int(11) DEFAULT NULL,
 * PRIMARY KEY (`id`)
 *) ENGINE=MyISAM AUTO_INCREMENT=20 DEFAULT CHARSET=utf8 COMMENT=' 商品详情属性 规格，温度，糖，奶油，加料 和商品详情 ''属性选择''   。 大  小   冷   热   糖  半份糖，全糖 ';
 * ```
 */
class SectionTypeModel extends Model
{
    protected $table = 'goods_section_type';

    protected $attributes = [
        'id',
        'title',
        'created_at',
        'updated_at'
    ];
}
