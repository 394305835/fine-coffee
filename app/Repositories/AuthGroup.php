<?php

namespace App\Repositories;

use App\Lib\Repository\MysqlRepository;
use App\Model\Mysql\AuthGroupModel;
use App\Model\Mysql\Model;

class AuthGroup extends MysqlRepository
{
    /**
     * 创建当前仓库的模型对象
     *
     * @Override
     * @return Model
     */
    public function makeModel(): Model
    {
        return AuthGroupModel::singleton();
    }
    public function deleteGroupByIds(array $uids): bool
    {
        return !!$this->model->whereIn('id', $uids)->delete();
    }
}
