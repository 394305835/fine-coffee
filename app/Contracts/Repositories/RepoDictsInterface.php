<?php

namespace App\Contracts\Repositories;

use App\Model\Mysql\DictsModel;

interface RepoDictsInterface
{
    /**
     * 获取表中 uid,title和username 为唯一key的一条记录
     *
     * @param int $uid
     * @param string $title
     * @param string $username
     * @return DictsModel|null
     */
    public function getDictUnionKey(int $uid, string $title, string $username): ?DictsModel;

    /**
     * 用主键更新
     *
     * @param integer $id
     * @param array $bean
     * @return boolean
     */
    public function updateById(int $id, array $bean): bool;

    /**
     * 用主键 ID 查询
     *
     * @param integer $id
     * @param integer $uid
     * @return DictsModel|null
     */
    public function findById(int $id, int $uid): ?DictsModel;

    /**
     * 用主键 ID 删除
     *
     * @param array $ids
     * @return boolean
     */
    public function deleteByIds(array $ids): bool;
}
