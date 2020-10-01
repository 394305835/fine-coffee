<?php

namespace App\Library;

use App\Contracts\Token\TokenInterface;

class AccessToken implements TokenInterface
{
    

     /**
     * 为用户生成一个token.
     * 如果生成失败将会是空串
     *
     * @param array $userinfo
     * @return string
     */
    public  function create(array $userinfo): string{
        return 1;
    }

    /**
     * 注销token
     *
     * @param string $token
     * @return boolean
     */
    public  function invalid(string $token): bool{
        return 1;
    }

    /**
     * 刷新token
     *
     * @param string $token
     * @return boolean
     */
    public  function refresh(string $token): bool{
        return 1;
    }

    /**
     * 检查token是否正确
     *
     * @param string $token
     * @return boolean
     */
    public  function check(string $token): bool{
        return 1;
    }
}
