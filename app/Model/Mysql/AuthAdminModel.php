<?php

namespace App\Model\Mysql;


class AuthAdminModel extends Model
{
    protected $table = 'admin';

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
