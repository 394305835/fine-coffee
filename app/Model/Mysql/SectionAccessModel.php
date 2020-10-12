<?php

namespace App\Model\Mysql;


/**
 * 商品详情 规格，温度，糖，奶油，加料    表
 * 
 * @property int $id 规格标签名
 * @property int $created_at   
 * @property int $updated_at   
 * 
 * ```sql
 *CREATE TABLE `fc_goods_section_access` (
 * `goods_id` int(10) unsigned NOT NULL COMMENT '商品ID',
 * `section_id` int(10) unsigned NOT NULL COMMENT '规格ID',
 * `created_at` int(11) DEFAULT NULL,
 * `updated_at` int(11) DEFAULT NULL,
 * UNIQUE KEY `uid_group_id` (`goods_id`,`section_id`),
 * KEY `group_id` (`section_id`),
 * KEY `uid` (`goods_id`)
 *  ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci ROW_FORMAT=DYNAMIC COMMENT='商品表和商品详情 规格，温度，糖，奶油，加料对应关系表';
 * ```
 */
class SectionAccessModel extends Model
{
    protected $table = 'goods_section_access';

    protected $attributes = [
        'goods_id',
        'section_id',
        'created_at',
        'updated_at'
    ];
}
