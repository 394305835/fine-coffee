<?php

namespace App\Model\Mysql;

/**
 * 
 * 
 * @property int $id
 * @property int $pid 父ID
 * @property string $type 区分该路由类型 router:前端路由 api: 请求接口
 * @property string $path 路径
 * @property string $title 规则名称
 * @property string $meta 路由元数据，其它数据，json格式
 * @property string $status 状态 1正常 0 禁止
 * @property int $sort 权重
 * @property int $created_at
 * @property int $updated_at
 * ```sql
 * CREATE TABLE `fc_auth_rule` (
 *  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
 *  `pid` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '父ID',
 *  `type` enum('router','api') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'router' COMMENT '区分该路由类型 router:前端路由 api: 请求接口',
 *  `path` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '' COMMENT '路径',
 *  `title` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '' COMMENT '规则名称',
 *  `meta` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT '路由元数据，其它数据，json格式',
 *  `status` tinyint(1) NOT NULL DEFAULT '1' COMMENT '状态 1正常 0 禁止',
 *  `sort` int(10) NOT NULL DEFAULT '0' COMMENT '权重',
 *  `created_at` int(11) DEFAULT NULL,
 *  `updated_at` int(11) DEFAULT NULL,
 *  PRIMARY KEY (`id`,`path`) USING BTREE,
 *  KEY `pid` (`pid`) USING BTREE,
 *  KEY `weigh` (`sort`) USING BTREE
 * ) ENGINE=InnoDB AUTO_INCREMENT=57 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci ROW_FORMAT=DYNAMIC COMMENT='节点表';
 * ```
 */
class AuthRuleModel extends Model
{
    protected $table = 'auth_rule';

    protected $attributes = [
        'id',
        'user_id',
        'goods_id',
        'lable_id',
        'pay_id',
        'sections',
        'created_at',
        'updated_at',
    ];
}
