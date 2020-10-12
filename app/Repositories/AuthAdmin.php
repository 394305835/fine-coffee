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
    public function getAdminById(int $id): ?AuthAdminModel
    {
        return $this->model->where('id', $id)->first($this->field);
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
