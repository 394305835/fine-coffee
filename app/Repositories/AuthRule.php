<?php

namespace App\Repositories;

use App\Model\Mysql\AuthRuleModel;
use App\Model\Mysql\Model;

class AuthRule
{
    /**
     * 创建当前仓库的模型对象
     *
     * @Override
     * @return Model
     */
    public function makeModel(): Model
    {
        return AuthRuleModel::singleton();
    }
}
