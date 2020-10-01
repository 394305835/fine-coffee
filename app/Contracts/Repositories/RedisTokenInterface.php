<?php

namespace App\Contracts\Repositories;

interface RedisTokenInterface
{

    /**
     * 获取全称 key,默认是所有子key
     *
     * @param string $mark
     * @return string
     */
    public function getTokenKey($mark = '*'): string;

    /**
     * 获取一个 token
     *
     * @param integer $uid
     * @return string|null
     */
    public function getToken(int $uid): ?string;

    /**
     * 添加一条 token
     *
     * @param integer $uid
     * @param string $token
     * @param integer $exp
     * @return boolean
     */
    public function create(int $uid, string $token, int $exp = 0): bool;

    /**
     * 删除用户在 redis 中的 token
     *
     * @param integer $uid
     * @return bool
     */
    public function remove(int $uid): bool;
}
