<?php

namespace App\Model\Mysql;



class AuthGroupAccessModel extends Model
{
    protected $table = 'auth_group_access';

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
