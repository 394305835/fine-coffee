<?php

namespace App\Model\Mysql;


/**
 * 支付方式模型
 * 
 * @property int $id  
 * @property string $title  支付类型名字
 * @property int $recommend   '1' COMMENT '是否推荐  1:推荐   0:不推荐
 * @property int $status   '是否禁用 1 :正常  0 禁用
 * @property int $created_at 
 * @property int $updated_at 
 * 
 * ```sql
 *CREATE TABLE `fc_paytype` (
 * `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
 * `title` varchar(255) NOT NULL COMMENT '支付类型名字',
 * `recommend` tinyint(1) NOT NULL DEFAULT '1' COMMENT '是否推荐  1:推荐   0:不推荐',
 * `status` tinyint(1) NOT NULL COMMENT '是否禁用 1 :正常  0 禁用',
 * `created_at` int(11) DEFAULT NULL,
 * `updated_at` int(11) DEFAULT NULL,
 * PRIMARY KEY (`id`)
 *) ENGINE=MyISAM DEFAULT CHARSET=utf8;
 * ```
 */
class PayTypeModel extends Model
{
    protected $table = 'paytype';

    protected $attributes = [
        'id',
        'title',
        'recommend',
        'status',
        'created_at',
        'updated_at'
    ];
}
