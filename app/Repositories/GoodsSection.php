<?php

namespace App\Repositories;

use App\Lib\Repository\MysqlRepository;
use App\Model\Mysql\GoodsSectionModel;
use App\Model\Mysql\Model;

class GoodsSection extends MysqlRepository
{
    /**
     * 创建当前仓库的模型对象
     *
     * @Override
     * @return Model
     */
    public function makeModel(): Model
    {
        return GoodsSectionModel::singleton();
    }
}
