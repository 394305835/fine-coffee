<?php

namespace App\Repositories;

use App\Lib\Repository\MysqlRepository;
use App\Model\Mysql\AuthRuleModel;
use App\Model\Mysql\Model;

class AuthRule extends MysqlRepository
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

    public function updateRuleById($where, array $bean): bool
    {
        return !!AuthRuleModel::where('id', $where)->update($bean);
    }
    public function getRuleByPath(string $path): bool
    {
        return !!AuthRuleModel::where('path', $path)->first();
    }
    public function deleteByIds(array $ruleIds): bool
    {
        return !!AuthRuleModel::whereIn('id', $ruleIds)->delete();
    }
}
