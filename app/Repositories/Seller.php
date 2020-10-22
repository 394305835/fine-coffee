<?php

namespace App\Repositories;

use App\Lib\Repository\MysqlRepository;
use App\Model\Mysql\Model;
use App\Model\Mysql\SellerModel;

class Seller extends MysqlRepository
{
    /**
     * 创建当前仓库的模型对象
     *
     * @Override
     * @return Model
     */
    public function makeModel(): Model
    {
        return SellerModel::singleton();
    }

    public function getSellerByUserName(string $username): ?SellerModel
    {
        return $this->findBy('username', $username);
    }

    /**
     * 用主键更新
     *
     * @Override
     * @param integer $id
     * @param array $bean
     * @return boolean
     */
    public function updateById(int $id, array $bean): bool
    {
        return $this->update([['id', '=', $id]], $bean);
    }
}
