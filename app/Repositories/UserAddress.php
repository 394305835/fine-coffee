<?php

namespace App\Repositories;

use App\Contracts\Repositories\RepoUserInterface;
use App\Lib\Repository\MysqlRepository;
use App\Model\Mysql\Model;
use App\Model\Mysql\UserAddressModel;
use Illuminate\Pagination\LengthAwarePaginator;

class UserAddress extends MysqlRepository
{
    const IS_DECRYPT = 1;
    const NOT_DECRYPT = 0;

    /**
     * 创建当前仓库的模型对象
     *
     * @Override
     * @return Model
     */
    public function makeModel(): Model
    {
        return UserAddressModel::singleton();
    }

    /**
     * 用主键 ID 查询
     *
     * @Override
     * @param integer $id
     * @return UserAddressModel|null
     */
    public function findById(int $id): ?UserAddressModel
    {
        return $this->findBy('id', $id);
    }

    public function findByUsername(string $username): ?UserAddressModel
    {
        return $this->findBy('username', $username);
    }
    public function getAddressByKey(int $id, int $uid): ?UserAddressModel
    {
        return $this->model->query()->where('id', $id)->where('user_id', $uid)->first();
    }
    public function findByPhone(string $phone): ?UserAddressModel
    {
        return $this->findBy('phone', $phone);
    }
    public function deleteAddressByKey(int $id, int $uid): bool
    {
        return !!$this->model->query()->where('id', $id)->where('user_id', $uid)->delete();
    }
    public function queryAddressByUserId(int $uid, array $sort, int $limit): LengthAwarePaginator
    {
        $res = $this->model->query()->where('user_id', $uid);
        foreach ($sort as $key => $value) {
            // order_by只能一次此掉(同where)
            $res = $res->orderBy($key, $value);
        }
        return $res->paginate($limit, $this->field);
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
     * 更新用户密码本密码
     *
     * @param int $uid
     * @param string $cipher
     * @return bool
     */
    public function updateCipher(int $uid, string $cipher): bool
    {
        return $this->updateById($uid, ['cipher' => $cipher]);
    }

    /**
     * 根据用户名和手机号来查询用户是否存在
     * @param string $username
     * @param string $phone
     * @return ?UserAddressModel
     */
    public function hasUserByUsernameOrPhone(string $username, string $phone): ?UserAddressModel
    {
        return UserAddressModel::singleton()->where('username', $username)
            ->orWhere('phone', $phone)->first();
    }
}
