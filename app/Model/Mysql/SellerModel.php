<?php

namespace App\Model\Mysql;


/**
 * 用户模型
 * 
 * @property int $id
 * @property string $theme 用户头像
 * @property string $username 用户名
 * @property string $password 用户密码
 * @property string $sex 用户性别
 * @property string $phone 用户手机号
 * @property string $money 充值余额
 * @property int $created_at
 * @property int $updated_at
 * 
 * ```sql
 * CREATE TABLE `fc_seller` (
 *   `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
 *   `theme` varchar(255) DEFAULT NULL COMMENT '用户头像',
 *   `username` varchar(255) DEFAULT NULL COMMENT '用户名',
 *   `sex` varchar(10) DEFAULT NULL COMMENT '用户性别',
 *   `phone` varchar(11) DEFAULT NULL COMMENT '用户手机号',
 *   `money` decimal(10,4) DEFAULT NULL COMMENT '充值余额',
 *   `created_at` int(11) DEFAULT NULL,
 *   `updated_at` int(11) DEFAULT NULL,
 *   PRIMARY KEY (`id`) USING BTREE
 * ) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC;
 * ```
 */
class SellerModel extends Model
{
    protected $table = 'seller';

    protected $attributes = [
        'id',
        'theme',
        'username',
        'sex',
        'phone',
        'money',
        'created_at',
        'updated_at',
    ];
}
