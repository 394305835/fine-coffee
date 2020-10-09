<?php

namespace App\Repositories;

use App\Contracts\Repositories\RepoUserInterface;
use App\Lib\Repository\MysqlRepository;
use App\Model\Mysql\Model;
use App\Model\Mysql\UserModel;

class User extends MysqlRepository implements RepoUserInterface
{
    const IS_DECRYPT = 1;
    const NOT_DECRYPT = 0;

    /**
     * 创建当前仓库的模型对象
     *
     * @Override
     * @return Model
     */
    public function makeModel(): Model
    {
        return UserModel::singleton();
    }

    /**
     * 用主键 ID 查询
     *
     * @Override
     * @param integer $id
     * @return UserModel|null
     */
    public function findById(int $id): ?UserModel
    {
        return $this->findBy('id', $id);
    }

    public function findByUsername(string $username): ?UserModel
    {
        return $this->findBy('username', $username);
    }
    public function findByPhone(string $phone): ?UserModel
    {
        return $this->findBy('phone', $phone);
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

    /**
     * 更新用户密码本密码
     *
     * @param int $uid
     * @param string $cipher
     * @return bool
     */
    public function updateCipher(int $uid, string $cipher): bool
    {
        return $this->updateById($uid, ['cipher' => $cipher]);
    }

    /**
     * 根据用户名和手机号来查询用户是否存在
     * @param string $username
     * @param string $phone
     * @return ?UserModel
     */
    public function hasUserByUsernameOrPhone(string $username, string $phone): ?UserModel
    {
        return UserModel::singleton()->where('username', $username)
            ->orWhere('phone', $phone)->first();
    }
}
