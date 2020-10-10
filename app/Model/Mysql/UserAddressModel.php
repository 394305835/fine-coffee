<?php

namespace App\Model\Mysql;


/**
 * 用户模型
 * 
 *@property int $id 
 *@property int $user_id 用户的ID
 *@property string $name 配送地址联系人
 *@property string $sex 性别
 *@property string $phone 手机号
 *@property string $address 收获地址
 *@property string $address_detailed 详细收获地址--门牌号
 *@property string $tag 地址类型
 *@property string $is_default_address
 *@property int $updated_at 
 *@property int $created_at  
 * 
 * ```sql
 * CREATE TABLE `fc_user_address` (
 * `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
 * `user_id` int(11) unsigned NOT NULL COMMENT '用户的ID',
 * `name` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL COMMENT '配送地址联系人',
 * `sex` enum('男','女') NOT NULL DEFAULT '男' COMMENT '性别（枚举类型）',
 * `phone` varchar(11) NOT NULL COMMENT '手机号',
 * `address` varchar(255) NOT NULL COMMENT '收获地址',
 * `address_detailed` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL COMMENT '详细收获地址--门牌号',
 * `tag` enum('家','公司','学校') DEFAULT NULL COMMENT '地址类型\r\n地址类型',
 * `is_default_address` tinyint(1) DEFAULT NULL COMMENT '0:不是 1：是',
 * `updated_at` int(11) DEFAULT NULL,
 * `created_at` int(11) DEFAULT NULL,
 * PRIMARY KEY (`id`),
 * KEY `user_id` (`user_id`)
 *) ENGINE=MyISAM DEFAULT CHARSET=utf8;
 * ```
 */
class UserAddressModel extends Model
{
    protected $table = 'user_address';

    protected $attributes = [
        'id',
        'user_id',
        'name',
        'sex',
        'phone',
        'address',
        'address_detailed',
        'tag',
        'is_default_address',
        'updated_at',
        'created_at',
    ];
}
