<?php

namespace App\Model\Mysql;


/**
 * 商品类别属性 与商品类别属性选择关系对应表
 * 商品属性 (规格，温度，糖度)  与 商品属性选择(大，小，热，冰，全糖，半糖)对应关系表
 */
class TypeAccessModel extends Model
{
    protected $table = 'section_type_access';

    protected $attributes = [
        'access_id',
        'type_id',
    ];
}
