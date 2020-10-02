<?php

namespace App\Repositories;

use App\Model\Mysql\AuthAdminModel;
use App\Model\Mysql\Model;

class AuthAdmin
{
    /**
     * 创建当前仓库的模型对象
     *
     * @Override
     * @return Model
     */
    public function makeModel(): Model
    {
        return AuthAdminModel::singleton();
    }
}
