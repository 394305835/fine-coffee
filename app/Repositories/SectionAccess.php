<?php

namespace App\Repositories;

use App\Lib\Repository\MysqlRepository;
use App\Model\Mysql\Model;
use App\Model\Mysql\SectionAccessModel;

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

    public function getGoodsBySectionIds($goodsIds)
    {
        return  $this->model->query()
            ->join('goods', 'goods.id', '=', 'goods_section_access.goods_id')
            ->whereIn('goods_section_access.goods_id', $goodsIds)
            ->get(['goods.*', 'section_id']);
    }
}
