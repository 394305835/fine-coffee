<?php

namespace App\Model\Mysql;


/**
 * 商品规格选配模型
 * 
 * @property int $id 规格标签名
 * @property int $pid 每个小规格名称的ID
 * @property int $type 是否分类   1:大类 (规格，温度，糖....)   2：小类(大，冰，热，无糖......)
 * @property int $recommend 是否推荐  1:推荐   0:不推荐',
 * @property int $created_at   
 * @property int $updated_at   
 * 
 * ```sql
 *CREATE TABLE `fc_goods_section` (
 * `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
 * `title` varchar(5) CHARACTER SET utf8 COLLATE utf8_general_ci DEFAULT NULL COMMENT '规格标签名',
 * `pid` int(11) unsigned NOT NULL COMMENT '每个小规格名称的ID',
 * `type` tinyint(1) NOT NULL DEFAULT '1' COMMENT '是否分类   1:大类 (规格，温度，糖....)   2：小类(大，冰，热，无糖......)',
 * `recommend` tinyint(1) NOT NULL DEFAULT '1' COMMENT '是否推荐  1:推荐   0:不推荐',
 * `created_at` int(11) DEFAULT NULL,
 * `updated_at` int(11) DEFAULT NULL,
 *PRIMARY KEY (`id`)
 *) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;
 * ```
 */
class GoodsSectionModel extends Model
{
    protected $table = 'goods_section';

    protected $attributes = [
        'id',
        'pid',
        'type',
        'recommend',
        'created_at',
        'updated_at'
    ];
}
