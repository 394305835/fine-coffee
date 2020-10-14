<?php

namespace App\Repositories;

use App\Lib\Repository\MysqlRepository;
use App\Model\Mysql\Model;
use App\Model\Mysql\SectionAccessModel;
use Illuminate\Database\Eloquent\Collection;

class SectionAccess extends MysqlRepository
{
    /**
     * 创建当前仓库的模型对象
     *
     * @Override
     * @return Model
     */
    public function makeModel(): Model
    {
        return SectionAccessModel::singleton();
    }


    public function getAccessByGoodsIdS(array $goodsIds): Collection
    {
        return  $this->model->whereIn('goods_id', $goodsIds)->get($this->field);
    }

    /**
     * select gsa.goods_id,gs.* 
     *  from fc_goods_section_access as gsa
     * join fc_goods_section as gs on gsa.section_id = gs.id
     *
     * @param array $goodsIds
     * @return Collection
     */
    public function getSectionByGoodsIds(array $goodsIds): Collection
    {
        return $this->model
            ->select('goods_section_access.goods_id', 'goods_section.id', 'goods_section.title')
            ->join('goods_section', 'goods_section.id', '=', 'goods_section_access.section_id')
            ->whereIn('goods_section_access.goods_id', $goodsIds)
            ->get();
    }
}
