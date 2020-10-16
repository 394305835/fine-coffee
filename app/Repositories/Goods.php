<?php

namespace App\Repositories;

use App\Lib\Repository\MysqlRepository;
use App\Model\Mysql\GoodsModel;
use App\Model\Mysql\Model;
use Illuminate\Database\Eloquent\Collection;

class Goods extends MysqlRepository
{
    /**
     * 创建当前仓库的模型对象
     *
     * @Override
     * @return Model
     */
    public function makeModel(): Model
    {
        return GoodsModel::singleton();
    }

    /**
     * 获取商品表的所有ID
     *
     * @return array
     */
    public function getGoodsIds(): array
    {
        $GoodsList = $this->model->singleton('id')->get()->toarray();
        return $GoodsList;
    }

    /**
     * 用商品ID查询商品信息
     *
     * @param array $ids
     * @return void
     */
    public function getGoodsByIds(array $ids): Collection
    {
        return $this->model->whereIn('id', $ids)->get();
    }

    /**
     * 根据ID查询商品信息
     *直接获取goods表中的所有记录
     * @return void
     */
    public function getGoodsInfo(array $goodsId): array
    {
        return $this->model->singleton()->get()->toarray();
    }


    /**
     * 根据商品ID来查询商品分类ID
     *Goods.ID-Good.list
     * @param [type] $good_ids
     * @return array
     */
    public function getCatetoryIds(array $goodIds): array
    {
        return $this->model->singleton('id')->get()->toarray();
        return [];
    }

    /**
     * 根据商品ID来查询商品分类ID
     *Goods.ID-Good.list
     * @param [type] $good_ids
     * @return array
     */
    public function getCatetoryByGoodsIds(array $goodIds): array
    {
        return [];
    }


    /**
     * 根据商品ID来查询商品属性ID
     *Goods.ID-Section.id
     * @param array $catetory_ids
     * @return array
     */
    public function getSectionByGoodsIds(array $goodIds): array
    {
        return [];
    }


    /**
     * 根据商品ID来查询商品属性选择ID
     *
     * @param array $section_ids
     * @return array
     */
    public function getTypeByGoodsIds(array $sectionIds): array
    {
        return [];
    }

    public function getGoodsById(int $goodsId): ?GoodsModel
    {
        return $this->findBy('id', $goodsId);
    }
}
