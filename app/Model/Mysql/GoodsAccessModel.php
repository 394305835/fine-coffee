<?php

namespace App\Model\Mysql;

class GoodsAccessModel extends Model
{
    protected $table = 'goods_access';

    protected $attributes = [
        'goods_id',
        'caterory_id',
        'section_id',
        'type_id',
    ];
}
