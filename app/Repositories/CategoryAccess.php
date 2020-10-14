<?php

namespace App\Repositories;

use App\Lib\Repository\MysqlRepository;
use App\Model\Mysql\CategoryAccessModel;
use App\Model\Mysql\Model;
use Illuminate\Database\Eloquent\Collection;

class CategoryAccess extends MysqlRepository
{
    /**
     * 创建当前仓库的模型对象
     *
     * @Override
     * @return Model
     */
    public function makeModel(): Model
    {
        return CategoryAccessModel::singleton();
    }


    /**
     * 用商品分类查询商品信息
     * (非常重要)
     * PS:查询的结果不会去重 商品会重复(因为一个商品可能对应对个分类)
     *
     * @param array $categoryIds
     * @return Collection
     */
    public function getGoodsByCategoryIds(array $categoryIds): Collection
    {
        return  $this->model->query()
            ->join('goods', 'goods.id', '=', 'goods_category_access.goods_id')
            ->whereIn('goods_category_access.category_id', $categoryIds)
            ->get(['goods.*', 'category_id']);
    }
}
