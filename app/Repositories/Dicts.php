<?php

namespace App\Repositories;

use App\Contracts\Repositories\RepoDictsInterface;
use App\Lib\Repository\MysqlRepository;
use App\Model\Mysql\DictsModel;
use App\Model\Mysql\Model;

class Dicts extends MysqlRepository implements RepoDictsInterface
{
    /**
     * 创建当前仓库的模型对象
     *
     * @Override
     * @return Model
     */
    public function makeModel(): Model
    {
        return DictsModel::singleton();
    }

    /**
     * 用主键 ID 查询
     *
     * @Override
     * @param integer $id
     * @param integer $uid
     * @return DictsModel|null
     */
    public function findById(int $id, int $uid): ?DictsModel
    {
        return $this->model->query()->where('id', $id)->where('uid', $uid)->first($this->field);
    }

    /**
     * 获取表中 uid,title和username 为唯一key的一条记录
     *
     * @Override
     * @param int $uid
     * @param string $title
     * @param string $username
     * @return DictsModel|null
     */
    public function getDictUnionKey(int $uid, string $title, string $username): ?DictsModel
    {
        return $this->model->query()
            ->where('uid', $uid)
            ->where('title', $title)
            ->where('username', $username)
            ->first($this->field);
    }

    /**
     * 用主键更新
     *
     * @Override
     * @param integer $id
     * @param array $bean
     * @return boolean
     */
    public function updateById(int $id, array $bean): bool
    {
        $pk = $this->model->getKeyName();
        unset($bean[$pk]);
        return $this->update([[$pk, '=', $id]], $bean);
    }

    /**
     * 用主键 ID 删除
     *
     * @Override
     * @param array $ids
     * @return boolean
     */
    public function deleteByIds(array $id): bool
    {
        return !!$this->model->query()->whereIn('id', $id)->delete();
    }
}
