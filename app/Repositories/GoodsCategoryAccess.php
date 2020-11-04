<?php

namespace App\Repositories;

use App\Lib\Repository\MysqlRepository;
use App\Model\Mysql\GoodsCategoryAccessModel;
use App\Model\Mysql\Model;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Pagination\LengthAwarePaginator;

class GoodsCategoryAccess extends MysqlRepository
{
    /**
     * 创建当前仓库的模型对象
     *
     * @Override
     * @return Model
     */
    public function makeModel(): Model
    {
        return GoodsCategoryAccessModel::singleton();
    }

    /**
     * 用分类查商品信息
     * 
     * @join
     * @param integer $categoryId
     * @return Collection
     */
    public function getGoodsByCategoryId(int $categoryId): Collection
    {
        return $this->model->query()
            ->join('goods', 'goods.id', '=', 'goods_category_access.goods_id')
            ->where('category_id', $categoryId)
            ->get([
                'goods.id', 'category_id', 'goods.theme', 'goods.name', 'goods.subtitle', 'goods.price', 'goods.is_sale'
            ]);
    }

    /**
     * 用分类查商品信息
     *
     * @join
     * @param integer [$categoryId] 当分类id为0 则查询所有
     * @param integer [$limit]
     * @return LengthAwarePaginator
     */
    public function paginateGoodsByCategoryId(int $categoryId = 0, int $limit = 15): LengthAwarePaginator
    {
        return $this->model->query()
            ->join('goods', 'goods.id', '=', 'goods_category_access.goods_id')
            // ->where('seller_id', $seller_id)
            ->when($categoryId, function ($query) use ($categoryId) {
                $query->where('category_id', $categoryId);
            })
            ->paginate($limit, [
                'goods.id', 'category_id', 'goods.theme', 'goods.name', 'goods.subtitle', 'goods.price', 'goods.is_sale'
            ]);
    }
}
