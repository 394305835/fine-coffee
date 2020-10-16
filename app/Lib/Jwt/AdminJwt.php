<?php

namespace App\Lib\Jwt;

use App\Lib\Constans;
use App\Repositories\Token\AdminToken;
use App\Repositories\Token\UserToken;

/**
 * JWT 认证
 *
 * ```sh
 * # 生成私钥
 * openssl genrsa -out pri_key.pem 1024
 * # 生成公钥
 * openssl rsa -in pri_key.pem -pubout -out pub_key.pem
 * ```
 */
class AdminJwt extends Jwt
{
    public function __construct()
    {
        parent::__construct();
        $this->repo = AdminToken::singleton();
    }

    public function create(array $payload): string
    {
        if (empty($uid = (int) $payload['uid']) || !is_numeric($uid)) {
            return '';
        }
        $token = $this->make($uid, UserToken::IDN);
        // 有效时间 = 过期时间 - 当前时间
        return $this->repo->create($uid, $token, $this->payload->exp - time()) ? $token : '';
    }
    public function check(string $token): bool
    {
        try {
            $payload = $this->parse($token);
            // 与 redis 中比较
            $rediToken = $this->repo->getToken((int) $payload->uid);
            return empty($rediToken) ? false : $token === $rediToken;
        } catch (\Throwable $th) {
            return false;
        }
        return false;
    }
    public function refresh(string $token): bool
    {
        $payload = $this->parse($token);
        // 如果一个天后将过期则刷新，否则不刷新
        if ($payload->exp - time() < Constans::TIME_DAY) {
            return $this->repo->create($payload->uid, $token, time() + Constans::TIME_DAY);
        }
        return true;
    }
    public function invalid(string $token): bool
    {
        $payload = $this->parse($token);
        if (!$payload->uid) {
            return false;
        }
        return $this->repo->remove($payload->uid);
    }
}
