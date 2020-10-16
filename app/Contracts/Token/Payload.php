<?php

namespace App\Contracts\Token;

use App\Lib\Constans;

class Payload
{

    /**
     * 签发者 可以为空
     *
     * @var string
     */
    public $iss = 'finecoffee.org';

    /**
     * 面象的用户，可以为空
     *
     * @var string
     */
    public $aud = 'finecoffee.org';

    /**
     * 签发时间
     *
     * @var int
     */
    public $iat;

    /**
     * 在什么时候jwt开始生效
     *
     * @var int
     */
    public $nbf;

    /**
     * token 过期时间
     *
     * @var int
     */
    public $exp;

    /**
     * 用户唯一身份标识
     *
     * @var int|string
     */
    public $uid;

    /**
     * 用户身份名称
     *
     * @var string 
     */
    public $idn;

    public function __construct(
        int $uid = 0,
        string $idn = '_normal_',
        int $exp = Constans::TOKEN_EXP_TIME
    ) {
        $this->uid = $uid;
        $this->idn = $idn;
        $this->iat = time();
        $this->nbf = $this->iat;
        $this->exp = $this->iat + $exp;
    }

    public static function warp(object $payload): Payload
    {
        $self = new static($payload->uid, $payload->idn);
        $self->iat = $payload->iat;
        $self->nbf = $payload->nbf;
        $self->exp = $payload->exp;
        return $self;
    }
}
