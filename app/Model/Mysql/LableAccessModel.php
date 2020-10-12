<?php

namespace App\Model\Mysql;


/**
 * 更新商品在相应类别上面有提示那个表
 */
class LableAccessModel extends Model
{
    protected $table = 'goods_lable_access';

    protected $attributes = [
        'goods_id',
        'category_id',
    ];
}
