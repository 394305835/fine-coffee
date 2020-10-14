<?php

namespace App\Contracts\Goods;

/**
 * 有关商品属性服务层逻辑
 */
interface SectionInterface
{
    //商品和属性 

    /**
     * 获取商品的属性
     *goods.id->sectionList
     * @param array $ids
     * @return array
     */
    public function getSection(array $ids);

    /**
     * 查询商品表和商品属性表的对应关系
     *goods.id->section.id ||  section.id->goods.id
     * @param array $ids
     * @param string $key
     * @return array
     */
    public function getSectionAccess(array $ids, $key = 'goods_id'): array;
}
