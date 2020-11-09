<?php

namespace App\Repositories;

use App\Lib\Repository\MysqlRepository;
use App\Model\Mysql\Model;
use App\Model\Mysql\OrderCartModel;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Collection;

class OrderCart extends MysqlRepository
{

    /**
     * 创建当前仓库的模型对象
     *
     * @Override
     * @return Model
     */
    public function makeModel(): Model
    {
        return OrderCartModel::singleton();
    }

    /**
     * 根据订单表UUID查询购物车中对应的信息
     *
     * @param array $orderUuid
     * @return Collection|null
     */
    public function getOrderCartByUuid(int $limit, array $sort, array $uuid): ?LengthAwarePaginator
    {
        $res =  $this->model->query()->whereIn('order_uuid', $uuid);
        foreach ($sort as $key => $value) {
            $res = $res->orderBy($key, $value);
        }
        return $res->paginate($limit);
    }
}
