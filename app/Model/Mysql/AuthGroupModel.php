<?php

namespace App\Model\Mysql;


class AuthGroupModel extends Model
{
    protected $table = 'auth_group';

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
