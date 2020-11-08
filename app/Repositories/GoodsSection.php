<?php

namespace App\Repositories;

use App\Lib\Repository\MysqlRepository;
use App\Model\Mysql\GoodsSectionModel;
use App\Model\Mysql\Model;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Contracts\Pagination\Paginator;
use Illuminate\Database\Eloquent\Collection;

class GoodsSection extends MysqlRepository
{
    /**
     * 创建当前仓库的模型对象
     *
     * @Override
     * @return Model
     */
    public function makeModel(): Model
    {
        return GoodsSectionModel::singleton();
    }

    /**
     * 查询商品属性表中是否有该属性
     *
     * @param string $sectionTitle
     * @return GoodsSectionModel
     */
    public function getTitleBySectionTitle(string $Title): ?GoodsSectionModel
    {
        return $this->model->where('title', $Title)->first();
    }

    /**
     * 新增商品属性
     *
     * @param integer $id
     * @param string $title
     * @return boolean
     */
    public function insertSections(int $id, array $title): bool
    {
        return $this->model->query()->insert([
            'id' => $id,
            'title' => $title
        ]);
    }

    /**
     * 根据ID删除商品属性
     *
     * @param integer $id
     * @return void
     */
    public function deleteById(array $ids)
    {
        return $this->model->whereIn('id', $ids)->delete();
    }

    /**
     * 根据ID修改商品属性
     *
     * @param integer $id
     * @return void
     */
    public function updateById(int $id, array $title)
    {
        return $this->model->where('id', $id)->update(['title' => $title]);
    }

    /**
     * 获取商品属性列表
     *
     * @param integer $limit
     * @param array $sort
     * @param array $where
     * @return LengthAwarePaginator|null
     */
    public function getSectionsList(int $limit, array $sort, array $where): ?LengthAwarePaginator
    {
        $res = $this->model->query()->where($where);
        foreach ($sort as $key => $value) {
            // order_by只能一次次掉(同where)
            $res = $res->orderBy($key, $value);
        }
        return $res->paginate($limit);
    }
}
