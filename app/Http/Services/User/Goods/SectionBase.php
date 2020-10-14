<?php

namespace App\Http\Services\User\Goods;

use App\Contracts\Goods\SectionTypeInterface;

/**
 * 该类提供了商品属性的基本方法
 */
class SectionBase implements SectionTypeInterface
{

    //商品和属性 

    /**
     * 获取商品的属性
     *goods.id->sectionList
     * @param array $ids
     * @return void
     */
    public function getSection(array $ids): array
    {
        return [];
    }

    /**
     * 查询商品表和商品属性表的对应关系
     *goods.id->section.id ||  section.id->goods.id
     * @param array $ids
     * @param string $key
     * @return void
     */
    public function getSectionAccess(array $ids, $key = 'goods_id'): array
    {
        return [];
    }


    //商品属性和商品属性选择

    /**
     * 查询商品属性表和商品属性选择表的对应关系
     * section.id->type.id   ||  type.id->section.id
     * @param array $ids
     * @param string $key
     * @return array
     */
    public function getTypeAccess(array $ids, $key = 'sections_id'): array
    {
        return [];
    }

    /**
     * 查询属性选择
     *  section.id->TypeList
     * @param array $sectionIds
     * @return array
     */
    public function getSectionType(array $sectionIds): array
    {
        return [];
    }
}
