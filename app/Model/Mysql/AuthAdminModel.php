<?php

namespace App\Model\Mysql;



/**
 * 
 * @property int $id
 * @property string $username 
 * @property string $nickname 
 * @property string $password 
 * @property string $avatar 
 * @property string $email 
 * @property int $loginfailure 
 * @property string $login_time 
 * @property int $status 
 * @property string $loginip 
 * @property int $created_at 
 * @property int $updated_at 
 * 
 * ```sql
 * CREATE TABLE `fc_admin` (
 * `id` int(10) unsigned NOT NULL AUTO_INCREMENT COMMENT 'ID',
 * `username` varchar(20) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '' COMMENT '用户名',
 * `nickname` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '' COMMENT '昵称',
 * `password` varchar(96) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '' COMMENT '密码',
 * `avatar` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '' COMMENT '头像',
 * `email` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '' COMMENT '电子邮箱',
 * `loginfailure` tinyint(1) unsigned DEFAULT '0' COMMENT '失败次数',
 * `login_time` datetime DEFAULT NULL COMMENT '最后一次登录时间',
 * `status` tinyint(1) NOT NULL DEFAULT '1' COMMENT '状态 1正常 0 禁止',
 * `loginip` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT '登录IP',
 * `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP COMMENT '创建时间',
 * `updated_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP COMMENT '更新时间',
 *PRIMARY KEY (`id`),
 *UNIQUE KEY `username` (`username`) USING BTREE
 *) ENGINE=InnoDB AUTO_INCREMENT=37 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci ROW_FORMAT=DYNAMIC COMMENT='管理员表';
 * ```
 */
class AuthAdminModel extends Model
{
    protected $table = 'admin';

    protected $attributes = [
        'id',
        'username',
        'nickname',
        'password',
        'avatar',
        'email',
        'loginfailure',
        'login_time',
        'status',
        'loginip',
        'created_at',
        'updated_at'
    ];
}
