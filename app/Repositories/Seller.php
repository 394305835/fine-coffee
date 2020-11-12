<?php

namespace App\Repositories;

use App\Lib\Repository\MysqlRepository;
use App\Model\Mysql\Model;
use App\Model\Mysql\SellerModel;
use Illuminate\Database\Eloquent\Collection;

class Seller extends MysqlRepository
{
    /**
     * 创建当前仓库的模型对象
     *
     * @Override
     * @return Model
     */
    public function makeModel(): Model
    {
        return SellerModel::singleton();
    }

    public function getSellerByUserName(string $username): ?SellerModel
    {
        return $this->findBy('username', $username);
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
        return $this->update([['id', '=', $id]], $bean);
    }

    /**
     * 获取商家个人信息
     *
     * @return Collection
     */
    public function getSellerInfo(): Collection
    {
        return $this->model->query()->where('id', SELLER_UID)->get();
    }

    /**
     * 用商家ID获取商家商家编号或者商家用户名
     *
     * @return Collection|null
     */
    public function getNumberOrUsernameById(array $post): ?SellerModel
    {
        return $this->model->query()
            ->where('number', $post['number'])
            ->orWhere('username', $post['username'])
            ->first();
    }

    /**
     * 根据商家ID存在查询商家是否存在
     *
     * @param [type] $id
     * @return SellerModel|null
     */
    public function getSellerById(): ?SellerModel
    {
        return $this->model->query()
            ->where('id', SELLER_UID)
            ->first();
    }

    /**
     * 根据ID删除商家
     *
     * @param [type] $id
     * @return boolean
     */
    public function deleteById(): bool
    {
        return $this->model->where('id', SELLER_UID)->delete();
    }
}
