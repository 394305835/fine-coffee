<?php

namespace App\Repositories\Token;

/**
 * token 放在 普通 key 里面,可以保证期时间有效性
 */
class SellerToken extends Token
{
    const IDN = 'seller';
    public function __construct()
    {
        parent::__construct();
        $this->key = $this->getKey(self::IDN);
    }
}
