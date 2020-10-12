<?php

namespace App\Model\Mysql;


/**
 * 商品分类模型表
 * 

 * @property string $id int
 * @property string $title varchar 类名
 * @property string $sort tinyint 排序
 * @property string $created_at int
 * @property string $updated_at int
 * 
 * ```sql
 * CREATE TABLE `fc_goods_lable` (
 * `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
 * `value` varchar(255) DEFAULT NULL COMMENT '类名',
 * `created_at` int(11) DEFAULT NULL,
 * `updated_at` int(11) DEFAULT NULL,
 * PRIMARY KEY (`id`)
 * ) ENGINE=MyISAM DEFAULT CHARSET=utf8;
 * ```
 */
class GoodsLableModel extends Model
{
    protected $table = 'goods_lable';

    protected $attributes = [
        'id',
        'value',
    ];
}
