<?php

namespace App\Contracts\Repository;

interface CreateRepository extends RepositoryInterface
{
    public function insert(array $bean): bool;
}
