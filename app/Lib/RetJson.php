<?php

namespace App\Lib;

use App\Contracts\RestFul\Ret\JsonRetInterface;

/**
 * 响应内容的 JSON 格式
 *
 * ```json
 * // 通常格式
 * {
 *   'code': 200
 *   // ...
 * }
 * // 实体数据
 * {
 *   'code' : 200,
 *   'entity' : {
 *     'id': 1,
 *     'age': 20,
 *     // ...
 *   }
 * }
 * // 列表数据
 * {
 *   'code' : 200,
 *   'list' : [
 *     {'id': 1, 'username': 'Withe'},
 *     {'id': 2, 'username': 'Black'},
 *     // ...
 *   ]
 * }
 * ```
 */
class RetJson implements JsonRetInterface
{
    /**
     * 响应HTTP状态码
     *
     * @var integer
     */
    protected $statusCode = 200;

    /**
     * 响应HTTP头
     *
     * @var array
     */
    protected $headers = [];

    /**
     * 响应的HTTP主体内容
     *
     * @var mixed
     */
    protected $body;

    /**
     * 响应主体里面的内容的操作码.
     * PS:主要对应
     *
     * @see \App\Lib\RetCode::class
     * @var integer
     */
    protected $retCode = 200;

    /**
     * 响应主体时面的响应key.
     *
     * 针对有响应数据时可定义的响应键
     *
     * @var string
     */
    protected $replyKey = 'msg';

    public function __construct(int $statusCode = 200, array $headers = [])
    {
        $this->statusCode = $statusCode;
        $this->headers = $headers;
    }

    /**
     * 创建一个实例
     *
     * @param integer $statusCode
     * @param array $headers
     * @return self
     */
    public static function make(int $statusCode = 200, array $headers = []): self
    {
        return new static($statusCode, $headers);
    }

    /**
     * 得到一个纯的实例
     *
     * @return self
     */
    public static function pure(): self
    {
        return new static();
    }

    /** getter/setter */

    /**
     * 获取 HTTP 状态码
     *
     * @Override
     * @return integer
     */
    public function getStatusCode(): int
    {
        return $this->statusCode;
    }

    /**
     * 获取HTTP响应头信息
     *
     * @Override
     * @param string $key
     * @return array|mixed
     */
    public function getHeaders($key = '')
    {
        if ($key) {
            return isset($this->headers[$key]) ? $this->headers[$key] : null;
        }
        return $this->headers;
    }

    /**
     * 获取HTTP响应内容
     *
     * @Override
     * @param mixed $body
     * @return mixed
     */
    public function getBody()
    {
        return $this->body;
    }

    /**
     * 获取 响应主体里面的内容的操作码
     *
     * @return integer
     */
    public function getRetCode(): int
    {
        return $this->retCode;
    }

    /**
     * 设置 HTTO 状态码
     *
     * @param integer $code
     * @return self
     */
    public function setStatusCode(int $code): self
    {
        $this->statusCode = $code;
        return $this;
    }

    /**
     * 设置HTTP响应头信息
     *
     * @param string|array $key
     * @param mixed $value
     * @return self
     */
    public function setHeaders($key, $value = ''): self
    {
        if (is_string($key)) {
            $this->headers[$key] = $value;
        } else if (is_array($key)) {
            $this->headers = $key;
        }
        return $this;
    }

    /**
     * 设置HTTP响应内容
     *
     * @param mixed $body
     * @return self
     */
    public function setBody($body): self
    {
        $this->body = $body;
        return $this;
    }

    /**
     * 设置响应主体里面的内容的操作码
     *
     * @param integer $retCode
     * @return self
     */
    public function setRetCode(int $retCode): self
    {
        $this->retCode = $retCode;
        return $this;
    }

    /** 响应 */

    /**
     * 返回一个实体型的body
     *
     * @Override
     * @param array|object $body 返回数据
     * @param string $key 返回数据键, 默认为 entity 键
     * @return self
     */
    public function entity($body = [], string $key = 'entity')
    {
        $key = $key ? $key : 'entity';
        return $this->setBody([
            'code' => $this->retCode,
            'msg' => RetCode::getMsgByCode($this->retCode),
            $key => $body,
        ]);
    }

    /**
     * 响应列表实体
     *
     * @Override
     * @param array|object $list 返回数据
     * @param string $key 返回数据键, 默认为 list 键
     * @return self
     */
    function list($list = [], string $key = 'list')
    {
        return $this->entity($list, $key);
    }

    /**
     * 响应一个错误信息.
     *
     * @Override
     * PS:正常情况下这里的 error 是返回一个错误消息的 key,而不是一串文本.
     * 如果提示了参数二则直接返回该消息
     *
     * @param string $default 响应错误消息
     * @param string $key 响应错误消息的键，默认 error
     * @return self
     */
    public function error(string $default = '', string $key = 'error')
    {
        $key = $key ? $key : 'error';
        $this->retCode = $this->retCode < 40000 ? 40000 : $this->retCode;
        return $this->setBody([
            'code' => $this->retCode,
            $key => $default ? $default : RetCode::getMsgKeyByCode($this->retCode, $default),
            // $key => RetCode::getMsgKeyByCode($code, $default)
        ]);
    }

    /**
     * 响应一个消息提示.
     *
     * @Override
     * 通常只会包含 code 和 msg 的提示信息
     *
     * @param string $defaultMsg 默认的提示信息,对就RestCode 中 msg() 中的消息
     * @param string $key 提示消息的键,默认 msg
     * @return self
     */
    public function msg(string $defaultMsg = "", string $key = 'msg')
    {
        $key = $key ? $key : 'msg';
        return $this->setBody([
            'code' => $this->retCode,
            $key => $defaultMsg ? $defaultMsg : RetCode::getMsgByCode($this->retCode, $defaultMsg),
        ]);
    }

    /**
     * 会直接响应一个单一内容.
     *
     * @Override
     * 只会包含单一内容,比如,只是一个数字,一个字符串...
     * @param mixed $reply 响应的内容,默认 retCode
     * @return self
     */
    public function single($reply = null)
    {
        return $this->setBody($reply ? $reply : $this->retCode);
    }

    /**
     * 响应代码中异常情况.
     *
     * @Override
     * @param \Throwable $th
     * @return self
     */
    public function throwable(\Throwable $th)
    {
        $this->setStatusCode(500)->setRetCode(RetCode::SERVER_ERROR);
        if (config('app.debug', false)) {
            return $this->error($th->getMessage());
        }
        return $this->error();
    }

    /**
     * Undocumented function
     *
     * @Override
     * @return array
     */
    public function toArray(): array
    {
        return [
            'statuCode' => $this->statusCode,
            'headers' => $this->headers,
            'body' => $this->body,
        ];
    }

    /**
     * Handle dynamic static method calls into the model.
     *
     * @param  string  $method
     * @param  array  $parameters
     * @return mixed
     */
    public static function __callStatic($method, $parameters)
    {
        dd('call call call');
        if (in_array($method, ['entity', 'list', 'error', 'msg', 'single'])) {
            return static::pure()->$method(...$parameters);
        }
        throw new \BadFunctionCallException("没有{$method}实例方法");
    }

    /**
     * 当该对象以函数的方式调用时,会自动得到返回结果
     *
     * 只提供对象为函数调用时的入口，得到 body 数据
     *
     * @return mixed
     */
    public function __invoke()
    {
        if (isset($this->body['code'])) {
            $this->body['code'] = $this->retCode;
        }
        return $this->body;
    }
}
