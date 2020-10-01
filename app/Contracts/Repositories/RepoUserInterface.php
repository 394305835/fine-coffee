<?php

namespace App\Contracts\Repositories;

use App\Model\Mysql\UserModel;

interface RepoUserInterface
{
    /**
     * 用主键 ID 查询
     *
     * @param integer $id
     * @return UserModel|null
     */
    public function findById(int $id): ?UserModel;

    /**
     * 用主键更新
     *
     * @param integer $id
     * @param array $bean
     * @return boolean
     */
    public function updateById(int $id, array $bean): bool;

    /**
     * 用户名查询
     *
     * @param string $username
     * @return UserModel|null
     */
    public function findByUsername(string $username): ?UserModel;

    /**
     * 更新用户密码本密码
     *
     * @param int $uid
     * @param string $cipher
     * @return bool
     */
    public function updateCipher(int $uid, string $cipher): bool;
}
