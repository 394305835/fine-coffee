<?php

namespace App\Repositories;

use App\Lib\Repository\MysqlRepository;
use App\Model\Mysql\Model;
use App\Model\Mysql\OrderModel;

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
}
