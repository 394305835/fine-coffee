<?php

namespace App\Contracts\RestFul\Ret;

/**
 * 响应JSON内容的格式
 */
interface JsonRetInterface extends RetInterface
{
    /**
     * 返回一个实体型的body
     *
     * @param array|object $body 返回数据
     * @param string $key 返回数据键, 默认为 entity 键
     * @return self
     */
    public function entity($body = [], string $key = 'entity');

    /**
     * 响应列表实体
     *
     * @param array|object $list 返回数据
     * @param string $key 返回数据键, 默认为 list 键
     * @return self
     */
    public function list($list = [], string $key = 'list');

    /**
     * 响应一个错误信息.
     *
     * PS:正常情况下这里的 error 是返回一个错误消息的 key,而不是一串文本.
     * 如果提示了参数二则直接返回该消息
     *
     * @param string $default 响应错误消息
     * @param string $key 响应错误消息的键，默认 error
     * @return self
     */
    public function error(string $default = '', string $key = 'error');

    /**
     * 响应一个消息提示.
     *
     * 通常只会包含 code 和 msg 的提示信息
     *
     * @param string $defaultMsg 默认的提示信息,对就RestCode 中 msg() 中的消息
     * @param string $key 提示消息的键,默认 msg
     * @return self
     */

    public function msg(string $defaultMsg = "", string $key = 'msg');
    /**
     * 会直接响应一个单一内容.
     *
     * 只会包含单一内容,比如,只是一个数字,一个字符串...
     * @param mixed $reply 响应的内容,默认 retCode
     * @return self
     */
    public function single($reply = null);

    /**
     * 响应代码中异常情况.
     *
     * @param \Throwable $th
     * @return self
     */
    public function throwable(\Throwable $th);
}
