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

    /**
     * 根据商品ID查询商品
     *
     * @param integer $goodsId
     * @return GoodsModel|null
     */
    public function getGoodsById(int $goodsId): ?GoodsModel
    {
        return $this->findBy('id', $goodsId);
    }

    /**
     * 判断商品表中是否存在相同的中文名和英文名
     *
     * @param string $name
     * @param string $subtitle
     * @return Collection
     */
    public function getGoodsNameOrsubTitle(string $name, string $subtitle): ?GoodsModel
    {
        return $this->model
            ->query()
            ->where('name', $name)
            ->orWhere('subtitle', $subtitle)
            ->first();
    }

    /**
     * 新增商品
     *
     * @param array $bean
     * @return int
     */
    public function insertGoods(array $bean): int
    {
        return $this->model->query()->insertGetId([
            'theme' => $bean['theme'],
            'name' => $bean['name'],
            'subtitle' => $bean['subtitle'],
            'price' => $bean['price'],
        ]);
    }

    /**
     * 根据商品ID删除商品表中的记录
     *
     * @param string $goodsId
     * @return boolean
     */
    public function deleteGoodsByGoodsId(array $goodsId): ?bool
    {
        return !!$this->model->whereIn('id', $goodsId)->delete();
    }

    /**
     * 根据商品ID更新商品信息
     *
     * @param string $goodsId
     * @param array $bean
     * @return boolean
     */
    public function updateById(string $goodsId, array $bean): ?bool
    {
        return !!$this->model->where('id', $goodsId)->update($bean);
    }
}
