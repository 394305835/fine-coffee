<?php

namespace App\Repositories;

use App\Lib\Repository\MysqlRepository;
use App\Model\Mysql\AuthAdminModel;
use App\Model\Mysql\Model;

class AuthAdmin extends MysqlRepository
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
    public function deleteAdminByIds(array $uids): bool
    {
        // !!= (bool)
        return !!$this->model->whereIn('id', $uids)->delete();
    }

    public function getAdminByIds($uids)
    {
        return $this->model->whereIn('id', $uids)->get($this->field);
    }

    public function getAdminByUserName(string $username): ?AuthAdminModel
    {
        return $this->model->where('username', $username)->first($this->field);
    }
}
