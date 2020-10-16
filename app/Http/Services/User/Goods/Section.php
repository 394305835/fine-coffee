<?php

namespace App\Http\Services\User\Goods;

use App\Lib\RetJson;
use App\Repositories\GoodsAccess;

/**
 * 该类提供了商品属性的组合方法
 */
class Section extends SectionBase
{

    /**
     * 判断当前商品是否具有传过来的商品属性
     *
     * @param integer $goodsId
     * @param array $typeIds
     * @return boolean
     */
    public function hasSectionType(int $goodsId, array $typeIds)
    {
        // 1--查询关系表看商品具有哪些type_id
        // 2--判断当前商品是否具有传过来的商品属性

        // 1--
        $access = GoodsAccess::singleton('type_id')->getAccessByGoodsId($goodsId);
        if (empty($access)) {
            return false;
        }
        $typeId = $access->type_id;
        $typeId = explode(',', $typeId);
        return $this->check($typeIds, $typeId);
    }
}
