<?php

namespace App\Contracts\Goods;

/**
 * 有关商品属性选择服务层逻辑
 */
interface SectionTypeInterface extends SectionInterface
{
    //商品属性和商品属性选择

    /**
     * 查询商品属性表和商品属性选择表的对应关系
     * section.id->type.id   ||  type.id->section.id
     * @param array $ids
     * @param string $key
     * @return array
     */
    public function getTypeAccess(array $ids, $key = 'sections_id'): array;

    /**
     * 查询属性选择
     *  section.id->TypeList
     * @param array $sectionIds
     * @return array
     */
    public function getSectionType(array $sectionIds): array;
}
