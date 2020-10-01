<?php

namespace App\Contracts\Repository;

interface UpdateRepository extends RepositoryInterface
{

    /**
     * 更新
     *
     * @param array $where
     * @param array $bean
     * @return boolean
     */
    public function update(array $where, array $bean): bool;

}
