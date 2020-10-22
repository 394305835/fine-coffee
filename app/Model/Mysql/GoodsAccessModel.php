<?php

namespace App\Model\Mysql;

class GoodsAccessModel extends Model
{
    protected $table = 'goods_access';


    protected $attributes = [
        'goods_id',
        'section_id',
        'type_id',
    ];


    /** getter 方法 */

    public function getSectionIdAttribute(string $value): array
    {
        return $value ? explode(',', $value) : [];
    }
    public function getTypeIdAttribute(string $value): array
    {
        return $value ? explode(',', $value) : [];
    }
}
