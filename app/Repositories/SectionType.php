<?php

namespace App\Repositories;

use App\Lib\Repository\MysqlRepository;
use App\Model\Mysql\Model;
use App\Model\Mysql\SectionTypeModel;
use Illuminate\Database\Eloquent\Collection;

class SectionType extends MysqlRepository
{
    /**
     * 创建当前仓库的模型对象
     *
     * @Override
     * @return Model
     */
    public function makeModel(): Model
    {
        return SectionTypeModel::singleton();
    }

    /**
     * 根据商品属性选择ID来查询商品属性选择列表
     *
     * @param [type] $typeIds
     * @return Collection
     */
    public function getTypeByIds($typeIds): Collection
    {
        return $this->model->join('goods_section', 'goods_section.id', 'goods_section_type.section_id')
            ->select('goods_section_type.id', 'goods_section_type.section_id', 'goods_section_type.title', 'goods_section.title as name')
            ->whereIn('goods_section_type.id', $typeIds)->get();
    }

    /**
     * 用商品ID来获取商品对应和商品属性选择
     *
     * @param [type] $goodsId
     * @return void
     */
    public function getGoodsByIds($typeIds)
    {
        return $this->model->join('goods', 'goods.id', 'goods_access.goods_id')
            ->select('goods.theme', 'goods.name', 'goods.price', '')
            ->whereIn('type_id', $typeIds)
            ->get();
    }
}
