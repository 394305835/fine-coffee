<?php

namespace App\Http\Services\User\Goods;

use App\Contracts\Goods\CategoryInterface;
use App\Repositories\Goods;

/**
 * 该类提供了商品分类信息的基础方法
 * 
 */
class CategoryBase implements CategoryInterface
{

    /**
     * 用分类查询商品
     * Category.id->GoodsList
     * @param array $CateIds
     * @return array
     */
    public function getGoods(array $CategoryIds): array
    {
        $goodsId = $this->getCategoryAccess($CategoryIds, 'category_id');
        return Goods::singleton()->getGoodsByIds($goodsId)->toArray();
    }

    /**
     * 获取商品所在的分类
     * Goods.id->CategoryuList
     * @param array $CateIds
     * @return array
     */
    public function getCategory(array $GoodIds): array
    {
        return [];
    }

    /**
     * 查询商品表和分类表的对应关系
     *Goods.id->Categroy.id  ||  Goods.id->Categroy.id  
     * @param array $ids
     * @param string $key
     * @return array
     */
    public function getCategoryAccess(array $ids, $key = 'goods_id'): array
    {
        return [];
    }
}
