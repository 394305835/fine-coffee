<?php

namespace App\Repositories;

use App\Lib\Repository\MysqlRepository;
use App\Model\Mysql\AuthGroupAccessModel;
use App\Model\Mysql\Model;
use PhpParser\Node\Stmt\Return_;

class AuthAccess extends MysqlRepository
{
    /**
     * 创建当前仓库的模型对象
     *
     * @Override
     * @return Model
     */
    public function makeModel(): Model
    {
        return AuthGroupAccessModel::singleton();
    }

    //
    public function getAccessByGroup($groupIds)
    {
        return $this->model->whereIn('group_id', $groupIds)->get();
    }

    //
    public function getAccessByUser($uids)
    {
        return $this->model->whereIn('uid', $uids)->get();
    }
}
