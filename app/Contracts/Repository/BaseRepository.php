<?php

namespace App\Contracts\Repository;

trait BaseRepository
{

    /**
     * 单对象缓存数组
     *
     * @var array
     */
    protected static $_repo = [];

    /**
     * 得到一个单例的对象
     *
     * @param string|array<string> ...$fields
     * @return static
     */
    public static function singleton(...$fields): self
    {
        $key = static::class;
        if (!isset(static::$_repo[$key])) {
            static::$_repo[$key] = static::factory(...$fields);
        }
        return static::$_repo[$key];
    }

    /**
     * 工厂方法
     *
     * @param string|array<string> ...$fields
     * @return static
     */
    public static function factory(...$fields): self
    {
        return new static(...$fields);
    }
}
