<?php

namespace App\Contracts\Token;


interface TokenInterface
{
    public function getPayload(string $token = ''): Payload;
    public function create(array $payload): string;
    public function check(string $token): bool;
    public function refresh(string $token): bool;
    public function invalid(string $token): bool;
}
