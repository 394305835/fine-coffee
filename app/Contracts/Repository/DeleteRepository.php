<?php

namespace App\Contracts\Repository;

interface DeleteRepository extends RepositoryInterface
{

    public function delete(array $where): bool;

}
