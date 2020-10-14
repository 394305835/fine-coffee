<?php

namespace App\Contracts\Goods;

/**
 *  有关商品服务层逻辑
 */
interface CategoryInterface
{

    /**
     * 用分类查询商品
     * Category.id->GoodsList
     * @param array $CateIds
     * @return array
     */
    public function getGoods(array $CateIds): array;

    /**
     * 获取商品所在的分类
     * Goods.id->CategoryuList
     * @param array $CateIds
     * @return array
     */
    public function getCategory(array $GoodIds): array;

    /**
     * 查询商品表和分类表的对应关系
     *Goods.id->Categroy.id  ||  Goods.id->Categroy.id  
     * @param array $ids
     * @param string $key
     * @return array
     */
    public function getCategoryAccess(array $ids, $key = 'goods_id'): array;
}
