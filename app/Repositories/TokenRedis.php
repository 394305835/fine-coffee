<?php

namespace App\Repositories;

use App\Contracts\Repositories\RedisTokenInterface;
use App\Lib\Repository\RedisRepository;

/**
 * token 放在 普通 key 里面,可以保证期时间有效性
 */
class TokenRedis extends RedisRepository implements RedisTokenInterface
{

    protected $key = 'finecoffee:jwt:user';

    /**
     * 获取token 在 redis 中的 key
     *
     * @Override
     * @param string|int $mark
     * @return string
     */
    public function getTokenKey($mark = '*'): string
    {
        return $this->key . ':' . $mark;
    }

    // 用户端登录后需要JWT生成一个TOKEN   JWT类只有一个  但是存储TOKEN的仓库有三个 ，分别是ADMIN  BESSIEN  USER
    // 在调用JWT的时候 如何区分应该使用哪一个仓库
    /**
     * 获取一个 token
     *
     * @Override
     * @param integer $uid
     * @return string|null
     */
    public function getToken(int $uid): ?string
    {
        return $this->redis->get($this->getTokenKey($uid));
    }

    /**
     * 添加一条 token
     *
     * @Override
     * @param integer $uid
     * @param string $token
     * @param integer $exp 接收过期时间秒数,不是过期时间戳
     * @return boolean
     */
    public function create(int $uid, string $token, int $exp = 0): bool
    {
        return !!$this->redis->setex($this->getTokenKey($uid), $exp, $token);
    }

    /**
     * 删除用户在 redis 中的 token
     *
     * @Override
     * @param integer $uid
     * @return bool
     */
    public function remove(int $uid): bool
    {
        return $this->redis->del($this->getTokenKey($uid));
    }
}
