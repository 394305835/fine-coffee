<?php

namespace App\Lib\Repository;

use App\Contracts\Repository\BaseRepository;

/**
 * Redis 普通操作类
 *
 * 该类只提供了 string 类的快捷操作
 */
abstract class RedisRepository
{
    use BaseRepository;

    /**
     * 当前redis仓库对应 key 键.
     *
     * 一般来说一个仓库也只有一个 key 值
     *
     * @var string
     */
    protected $key = '';

    /**
     * redis 实例对象
     *
     * 由容器生成的单例对象
     *
     * @see \Illuminate\Redis\RedisServiceProvider
     * @var \Predis\Client
     */
    protected $redis;

    public function __construct()
    {
        $this->redis = app('redis');
    }

    public function getKey(string $mark = ''): string
    {
        if ($mark) {
            return $this->compose($this->key, $mark);
        }
        return $this->key;
    }

    public function compose(string $key, string $staff): string
    {
        return $key . ':' . $staff;
    }

    public function refersh(string $key, int $exp): bool
    {
        $ttl = $this->redis->ttl($key);
        return $this->redis->expire($key, $ttl + $exp);
    }
}
