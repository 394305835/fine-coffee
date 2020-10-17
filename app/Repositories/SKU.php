<?php

namespace App\Repositories;

use App\Lib\Repository\MysqlRepository;
use App\Model\Mysql\GoodsSKUModel;
use App\Model\Mysql\Model;

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

}
