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

    /**
     * 添加关系表数据
     *
     * @param integer $goodsId
     * @param array $section_id
     * @param array $type_id
     * @return boolean
     */
    public function insertAccess(int $goodsId, string $section_id, string $type_id): bool
    {
        return $this->model->insert([
            'goods_id' => $goodsId,
            'section_id' => $section_id,
            'type_id' => $type_id,
        ]);
    }

    /**
     * 根据商品ID删除关系表中对应的数据
     *
     * @param string $goodsId
     * @return boolean
     */
    public function deleteAccessByGoodsId(array $goodsId): ?bool
    {
        return !!$this->model->whereIn('goods_id', $goodsId)->delete();
    }


    /**
     * 根据商品ID更新关系表记录
     *
     * @param string $goodsId
     * @param array $bean
     * @return boolean
     */
    public function updateByGoodsId(string $goodsId, array $data): ?bool
    {
        return !!$this->model->where('goods_id', $goodsId)->update($data);
    }
}
