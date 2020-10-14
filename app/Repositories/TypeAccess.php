<?php

namespace App\Repositories;

use App\Lib\Repository\MysqlRepository;
use App\Model\Mysql\Model;
use App\Model\Mysql\TypeAccessModel;
use Illuminate\Database\Eloquent\Collection;

class TypeAccess extends MysqlRepository
{
    /**
     * 创建当前仓库的模型对象
     *
     * @Override
     * @return Model
     */
    public function makeModel(): Model
    {
        return TypeAccessModel::singleton();
    }

    /**
     * select sta.section_id,gst.*
     * from fc_section_type_access as sta
     * join  fc_goods_section_type as gst on gst.id = sta.type_id
     *
     * @param [type] $sectionIds
     * @return Collection
     */
    public function getTypeBySectionIds($sectionIds): Collection
    {
        return $this->model->join('goods_section_type', 'goods_section_type.id', '=', 'section_type_access.type_id')
            ->whereIn('section_type_access.section_id', $sectionIds)
            ->select('goods_section_type.id', 'goods_section_type.title', 'section_type_access.section_id')
            ->get();
    }
}
