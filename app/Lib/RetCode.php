<?php

namespace App\Lib;

class RetCode
{
    /**
     * 响应成功
     *
     * @message OK
     */
    const OK = 200;
    const CREATED = 201;

    const ARG_ERROR = 40000;
    const AUTH_TOKEN_NULL = 40101;
    const AUTH_TOKEN_FAIL = 40102;
    const AUTH_TOKEN_INVIDE = 40103;

    const AUTH_USER_EXISTS = 40104;
    const AUTH_USER_NOT_EXIST = 40105;
    const AUTH_USER_WRONG_PASSWORD = 40106;
    const AUTH_RULE_INVALID = 40107;
    
    const ENTITY_PUT_FAIL = 41001;
    const ENTITY_NOTMATCH = 41002;
    const ENTITY_DICT_EXISTS = 41003;

    const DICT_CIPHER_NOT_EXIST = 41101;
    const DICT_CIPHER_NOTMATCH = 41102;

    const SERVER_ERROR = 50000;

    public static function msg(): array
    {
        return [
            200 => 'OK',
            201 => '创建成功',
            40000 => '参数错误',
            40101 => 'token 不能为空',
            40102 => 'token 验证失败',
            40103 => 'token 已失效',
            41001 => '资源创建失败',
            41002 => '资源不匹配',
            50000 => '服务器错误',
        ];
    }
    public static function msgKey(): array
    {
        return [
            200 => 'OK',
            201 => 'created',

            /**
             * 40001 开始为参数,权限等
             */
            40000 => 'arg.invalid',

            40101 => 'auth.token.empty',
            40102 => 'auth.token.fail',
            40103 => 'auth.token.invalid',
            40104 => 'auth.user.exists',
            40105 => 'auth.user.notexist',
            40106 => 'auth.user.wrong_password',
            40107 => 'auth.rule.invalid',

            41001 => 'entity.put.fail',
            41002 => 'entity.notmatch',
            41003 => 'entity.dict.exists',

            41101 => 'dict.cipher.not.exist',
            41102 => 'dict.cipher.notmatch',

            /**
             * 500001 开始为服务器,代理,异常等
             */
            50000 => 'serve.error',

        ];
    }

    /**
     * 获取该类定义常量对应的消息
     *
     * @param integer $code
     * @return string
     */
    public static function getMsgByCode(int $code, string $defaultMsg = ''): string
    {
        $msg = static::msg();
        return isset($msg[$code]) ? $msg[$code] : $defaultMsg;
    }

    /**
     * 获取该类定义常量对应的消息key
     *
     * @param integer $code
     * @return string
     */
    public static function getMsgKeyByCode(int $code, string $defaultMsg = ''): string
    {
        $msg = static::msgKey();
        return isset($msg[$code]) ? $msg[$code] : $defaultMsg;
    }
}
