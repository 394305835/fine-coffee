<?php

namespace App\Repositories\Token;

/**
 * token 放在 普通 key 里面,可以保证期时间有效性
 */
class AdminToken extends Token
{

    const IDN = 'admin';
    public function __construct()
    {
        parent::__construct();
        $this->key = $this->getKey(SELF::IDN);
    }
}
