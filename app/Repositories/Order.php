<?php

namespace App\Repositories;

use App\Lib\Repository\MysqlRepository;
use App\Model\Mysql\Model;
use App\Model\Mysql\OrderModel;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Collection;

class Order extends MysqlRepository
{

    const PAY_NO = 0;
    const PAY_CANCEL = 1;
    const PAY_EXPIRED = 2;
    const PAY_OK = 3;
    const PAY_FAIL = 4;

    /**
     * 创建当前仓库的模型对象
     *
     * @Override
     * @return Model
     */
    public function makeModel(): Model
    {
        return OrderModel::singleton();
    }
    /**
     * 用UUID获取订单信息
     *
     * @param string $uuid
     * @return OrderModel|null
     */
    public function getOrderByUuid(string $uuid): ?OrderModel
    {
        return $this->model
            ->select('id', 'seller_id', 'user_id', 'pay_id', 'pay_status', 'status', 'place_time', 'pay_time', 'created_time')
            ->where('uuid', $uuid)
            ->get();
    }

    /**
     * 更新UUID所在的订单的支付状态的值
     *
     * @param [type] $uuid
     * @return boolean
     */
    public function updateByUuid(string $uuid, array $bean): bool
    {
        return $this->update([['uuid', '=', $uuid]], $bean);
    }
    /**
     * 后台获取全部订单
     *
     * @param integer $limit
     * @param array $sort
     * @param array $where
     * @return LengthAwarePaginator|null
     */
    public function getAllOrder(int $limit, array $sort, array $where): ?LengthAwarePaginator
    {
        $res = $this->model->query()->where($where);
        foreach ($sort as $key => $value) {
            $res = $res->orderBy($key, $value);
        }
        return $res->paginate($limit);
    }

    /**
     * 用户获取全部订单
     *
     * @param integer $limit
     * @param array $sort
     * @param array $where
     * @return LengthAwarePaginator|null
     */
    public function getOrderByUserId(int $limit, array $sort, array $where): ?LengthAwarePaginator
    {
        $res = $this->model->query()->where($where)->where('user_id', USER_UID);
        foreach ($sort as $key => $value) {
            $res = $res->orderBy($key, $value);
        }
        return $res->paginate($limit);
    }

    /**
     * 商家获取全部订单
     *
     * @param integer $limit
     * @param array $sort
     * @param array $where
     * @return LengthAwarePaginator|null
     */
    public function getOrderBySellerId(int $limit, array $sort, array $where): ?LengthAwarePaginator
    {
        $res = $this->model->query()->where($where)->where('seller_id', SE_UID);
        foreach ($sort as $key => $value) {
            $res = $res->orderBy($key, $value);
        }
        return $res->paginate($limit);
    }
}
