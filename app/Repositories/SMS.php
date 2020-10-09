<?php

namespace App\Repositories;

use App\Contracts\Repositories\RedisTokenInterface;
use App\Lib\Repository\RedisRepository;

/**
 * token 放在 普通 key 里面,可以保证期时间有效性
 */
class SMS extends RedisRepository
{
    protected $key = 'codebook:sms:user';

    /**
     * 获取一个 短信验证码
     *
     * @Override
     * @param integer $uid
     * @return string|null
     */
    public function getSMS(string $phone): ?string
    {
        return $this->reids->get($this->getKey($phone));
    }

    /**
     * 添加一条 短信验证码
     *
     * @Override
     * @param string $phone
     * @param string $code
     * @param integer $exp 接收过期时间秒数,不是过期时间戳
     * @return boolean
     */
    public function create(string $phone, string $code, int $exp = 0): bool
    {
        return !!$this->reids->setex($this->getKey($phone), $exp, $code);
    }

    /**
     * 删除用户在 redis 中的 短信验证码
     *
     * @Override
     * @param string $phone
     * @return bool
     */
    public function remove(string $phone): bool
    {
        return $this->reids->del($this->getKey($phone));
    }
}
