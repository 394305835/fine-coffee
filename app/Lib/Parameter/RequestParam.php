<?php

namespace App\Lib\Parameter;

use App\Contracts\Parameter\RequestParameterInterface;
use Illuminate\Http\Request;

/**
 * 请求参数组装
 */
abstract class RequestParam implements RequestParameterInterface
{
    /**
     * 请求实例对象
     *
     * @var Request
     */
    protected $request;

    public function __construct()
    {
        $this->request = request();
    }

    /**
     * 构建 where 条件查询
     *
     */
    abstract public function build(): array;

    /**
     * 得到请求实例中的某一个键值.
     *
     * @param string $key
     * @return mixed
     */
    public function getRequestParam(string $key)
    {
        if ($this->request) {
            return $this->request->input($key, null);
        }
        return null;
    }

    /**
     * 得到某个键的值.
     * 该键不存在数组 $default 中则从请求实例中取
     *
     * @param string $key
     * @param array $default
     * @return mixed
     */
    public function parseParam(string $key, array $default = [])
    {
        return isset($default[$key]) ? $default[$key] : $this->getRequestParam($key);
    }
}
