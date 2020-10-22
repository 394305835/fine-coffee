<?php

namespace App\Http\Services\User\Goods;

use App\Lib\RetJson;
use App\Repositories\GoodsAccess;
use App\Repositories\SectionType;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Arr;

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


    /**
     * 查询商品 section_id 和 type_id
     *
     * @param array $goodsIds
     * @return Collection
     */
    public function getGoodsTypeByGoodsIds(array $goodsIds): Collection
    {
        $goodsAccessCollection = GoodsAccess::singleton('goods_id', 'section_id', 'type_id')->getAccessByGoodsIds($goodsIds);
        // $goodsAccess = array_column($goodsAccessCollection->toArray(), null, 'goods_id');

        // 3.商品属性信息
        // 将 section_id 和 type_id 转换成数组
        $typeIds = $goodsAccessCollection->pluck('type_id')->toArray();
        $typeIds = Arr::flatten($typeIds, 2);
        $types = SectionType::singleton()->getTypeByIds($typeIds)->groupBy('section_id')->toArray();

        foreach ($goodsAccessCollection as $_acc) {
            // NOTE: 防止`ErrorException: Indirect modification of overloaded property`
            $temp = [];
            foreach ($_acc->section_id as $_sectionId) {
                $temp[] = $types[$_sectionId];
            }
            $_acc->sections = $temp;
        }
        return $goodsAccessCollection;
    }
}
