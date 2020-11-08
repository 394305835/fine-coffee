<?php

namespace App\Repositories;

use App\Lib\Repository\MysqlRepository;
use App\Model\Mysql\Model;
use App\Model\Mysql\SectionTypeModel;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Contracts\Pagination\Paginator;
use Illuminate\Database\Eloquent\Collection;

class SectionType extends MysqlRepository
{
    /**
     * 创建当前仓库的模型对象
     *
     * @Override
     * @return Model
     */
    public function makeModel(): Model
    {
        return SectionTypeModel::singleton();
    }

    /**
     * 根据商品属性选择ID来查询商品属性选择列表
     *
     * @join
     * @param array $typeIds
     * @return Collection
     */
    public function getTypeByIds($typeIds): Collection
    {
        return $this->model->join('goods_section', 'goods_section.id', 'goods_section_type.section_id')
            ->select('goods_section_type.id', 'goods_section_type.section_id', 'goods_section_type.title', 'goods_section.title as name')
            ->whereIn('goods_section_type.id', $typeIds)->get();
    }

    /**
     * 用商品ID来获取商品对应和商品属性选择
     *
     * @param [type] $goodsId
     * @return void
     */
    public function getGoodsByIds($typeIds): Collection
    {
        return $this->model->whereIn('id', $typeIds)->get($this->field);
    }

    /**
     * 判断商品属性选择是否存在
     *
     * @param [type] $typeIds
     * @return Collection
     */
    public function hasSectionType(array $typeIds): Collection
    {
        return $this->model
            ->select('section_id')
            ->whereIn('id', $typeIds)
            ->get();
    }

    /**
     * 查询商品属性表中是否有该属性选择
     *
     * @param string $sectionTitle
     * @return GoodsSectionModel
     */
    public function getTitleByTypeTitle(string $Title): ?SectionTypeModel
    {
        return $this->model->where('title', $Title)->first();
    }

    /**
     * 新增商品属性选择
     *
     * @param integer $id
     * @param string $title
     * @return boolean
     */
    public function insertType(int $id, array $bean): bool
    {
        return $this->model->query()->insert([
            'id' => $id,
            'section_id' => $bean['sectionId'],
            'title' => $bean['title']
        ]);
    }

    /**
     * 根据ID删除商品属性选择
     *
     * @param integer $id
     * @return void
     */
    public function deleteById(array $ids)
    {
        return $this->model->whereIn('id', $ids)->delete();
    }

    /**
     * 根据ID修改商品属性选择
     *
     * @param integer $id
     * @return void
     */
    public function updateById(int $id, array $post)
    {
        return $this->model->where('id', $id)->update([
            'section_id' => $post['sectionId'],
            'title' => $post['title'],
        ]);
    }

    /**
     * 获取商品属性选择列表
     *
     * @param integer $limit
     * @param array $sort
     * @return Paginator|null
     */
    public function getTypesList(int $limit, array $sort, array $where): ?LengthAwarePaginator
    {
        $res = $this->model->query()->where($where);
        foreach ($sort as $key => $value) {
            // order_by只能一次次掉(同where)
            $res->orderBy($key, $value);
        }
        return $res->paginate($limit);
    }
}
