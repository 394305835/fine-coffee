<?php

namespace App\Model\Mysql;


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
