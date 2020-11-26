<?php

namespace App\Repositories;

use App\Lib\Repository\MysqlRepository;
use App\Model\Mysql\CategoryModel;
use App\Model\Mysql\Model;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Collection;

class Category extends MysqlRepository
{
    /**
     * 创建当前仓库的模型对象
     *
     * @Override
     * @return Model
     */
    public function makeModel(): Model
    {
        return CategoryModel::singleton();
    }


    public function getListSort(string $sort, string $sortBy = 'asc'): Collection
    {
        return $this->model->query()->select('id','title','sort')->orderBy($sort, $sortBy)->get();
    }

    public function getCategoryByIds(array $categoryIds): Collection
    {
        return $this->model->whereIn('id', $categoryIds)->get($this->field);
    }
    /**
     * 根据分类title来查询是否存在分类
     *
     * @param string $title
     * @return Collection
     */
    public function getTitleByCategoryTitle(string $title): Collection
    {
        return $this->model->where('title', $title)->get();
    }

    /**
     * 根据分类ID来查询是否存在
     *
     * @param integer $id
     * @return Collection
     */
    public function getCategoryId(int $id): Collection
    {
        return $this->model->whereIn('id', $id)->get();
    }

    /**
     * 新增商品分类
     *
     * @param integer $id
     * @param string $title
     * @return boolean
     */
    public function insertCategory(string $title, int $sort): bool
    {
        return $this->model->query()->insert([
            'title' => $title,
            'sort' => $sort
        ]);
    }

    /**
     * 根据ID删除商品分类
     *
     * @param integer $id
     * @return void
     */
    public function deleteById(array $ids)
    {
        return $this->model->whereIn('id', $ids)->delete();
    }

    /**
     * 根据ID修改商品分类
     *
     * @param integer $id
     * @param string $title
     * @param integer $sort
     * @return void
     */
    public function updateById(int $id, string $title, int $sort)
    {
        return $this->model->where('id', $id)->update([
            'title' => $title,
            'sort' => $sort
        ]);
    }

    /**
     * 获取商品分类列表
     *
     * @param integer $limit
     * @param array $sort
     * @return Paginator|null
     */
    public function getCategorysList(int $limit, array $sort, array $where): ?LengthAwarePaginator
    {
        $res = $this->model->query()->where($where);
        foreach ($sort as $key => $value) {
            // order_by只能一次次掉(同where)
            $res->orderBy($key, $value);
        }
        return $res->paginate($limit);
    }
}
