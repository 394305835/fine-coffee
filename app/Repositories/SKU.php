<?php

namespace App\Repositories;

use App\Lib\Repository\MysqlRepository;
use App\Model\Mysql\GoodsSKUModel;
use App\Model\Mysql\Model;
use Illuminate\Contracts\Pagination\Paginator;
use Illuminate\Database\Eloquent\Collection;

class SKU extends MysqlRepository
{
    /**
     * 创建当前仓库的模型对象
     *
     * @Override
     * @return Model
     */
    public function makeModel(): Model
    {
        return GoodsSKUModel::singleton();
    }

    /**
     * 获取商品库存
     *
     * @param integer $goods_id
     * @return integer
     */
    public function getSKU(int $goods_id): int
    {
        return (int) $this->model->query()->where('goods_id', $goods_id)->value('sku');
    }

    /**
     * 减少商品库存
     * PS:这个方法只允许一个地方调用，CreateOrderPodcast
     *
     * @param integer $goods_id
     * @param integer $num
     * @return boolean
     */
    public function decrementSKU(int $goods_id, int $num): bool
    {
        return $this->model->query()
            ->where('goods_id', $goods_id)
            // ->where('sku', '>', $num)
            ->decrement('sku', $num);
    }

    /**
     * 严格验证数量是否充足
     * IMPROATANT:
     *
     * @return bool
     */
    public function checkSKU(int $goods_id, int $number): bool
    {
        // TODO:严格验证商品库存
        // NOTE:规避超卖情况
        // 1. 查询库存数量
        $sku = SKU::singleton()->getSKU($goods_id);
        if ($sku < 1 || $number > $sku) {
            return false;
        }
        return true;
    }

    /**
     * 增加商品库存
     *
     * @param integer $goodsId
     * @param integer $number
     * @return boolean
     */
    public function addGoodsSku(int $goodsId, int $number): bool
    {
        return $this->model->where('id', $goodsId)->increment('sku', $number);
    }

    /**
     * 减少商品库存
     *
     * @param integer $goodsId
     * @param integer $number
     * @return boolean
     */
    public function deleteGoodsSku(int $goodsId, int $number): bool
    {
        return $this->model->where('id', $goodsId)->decrement('sku', $number);
    }

    /**
     * 修改商品库存
     *
     * @param integer $goodsId
     * @param integer $number
     * @return boolean
     */
    public function updateGoodsSku(int $goodsId, int $number): bool
    {
        return $this->model->query()->where('id', $goodsId)->update(['sku' => $number]);
    }

    /**
     * 获取全部商品库存
     *
     * @param integer $goods_id
     * @return integer
     */
    public function getAllSKU(int $limit, array $sort): ?Paginator
    {
        return  $this->model->query()->paginate($limit);
    }
}
