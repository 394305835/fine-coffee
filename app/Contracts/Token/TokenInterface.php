<?php

namespace App\Contracts\Token;


interface TokenInterface
{
    public function getPayload(string $token = ''): \stdClass;
    public function create(array $payload): string;
    public function check(string $token): bool;
    public function refresh(string $token): bool;
    public function invalid(string $token): bool;

    /**
     * 该方法区分使用哪个存储token的仓库
     *
     * @param Token $token
     */
    public function use($token);
}
