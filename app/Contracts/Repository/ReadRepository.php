<?php

namespace App\Contracts\Repository;

interface ReadRepository extends RepositoryInterface
{
    public function all();
    public function paginate(int $perPage, int $offset = 0);
}
