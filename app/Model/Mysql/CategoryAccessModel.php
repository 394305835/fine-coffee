<?php

namespace App\Model\Mysql;


/**
 * 商品和商品类别对应关系表
 */
class CategoryAccessModel extends Model
{
    protected $table = 'goods_category_access';

    protected $attributes = [
        'goods_id',
        'category_id',
    ];
}
