<?php

namespace App\Repositories;

use App\Lib\Repository\MysqlRepository;
use App\Model\Mysql\GoodsAccessModel;
use App\Model\Mysql\Model;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Arr;

class GoodsAccess extends MysqlRepository
{
    /**
     * 创建当前仓库的模型对象
     *
     * @Override
     * @return Model
     */
    public function makeModel(): Model
    {
        return GoodsAccessModel::singleton();
    }

    /**
     * 类别的ID查询类别对应商品的信息(包括商品，商品属性，商品属性选择)
     *
     * @param [type] $categoryIds
     * @return void
     */
    public function getGoodsByCategoryIds($categoryIds): Collection
    {
        return $this->model->join('goods', 'goods.id', '=', 'goods_access.goods_id')
            ->whereIn('category_id', $categoryIds)
            ->get(['goods_access.category_id', 'goods.id', 'goods.theme', 'goods.name', 'goods.subtitle', 'goods.price', 'goods.is_sale', 'goods_access.section_id', 'goods_access.type_id']);
    }


    public function getAccessByGoodsIds(array $goodsIds): Collection
    {
        return $this->model->whereIn('goods_id', $goodsIds)->get($this->field);
    }
    public function getAccessByGoodsId(int $goodsId): ?GoodsAccessModel
    {
        return $this->findBy('goods_id', $goodsId);
    }

}
