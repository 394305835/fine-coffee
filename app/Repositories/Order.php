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
}
