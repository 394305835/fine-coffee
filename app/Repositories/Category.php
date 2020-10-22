<?php

namespace App\Repositories;

use App\Lib\Repository\MysqlRepository;
use App\Model\Mysql\CategoryModel;
use App\Model\Mysql\Model;
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
        return $this->model->query()->where('id', '<', 4)->orderBy($sort, $sortBy)->get($this->field);
    }

    public function getCategoryByIds(array $categoryIds): Collection
    {
        return $this->model->whereIn('id', $categoryIds)->get($this->field);
    }
}
