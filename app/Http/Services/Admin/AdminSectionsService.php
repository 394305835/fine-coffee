<?php

namespace App\Http\Services\Admin;

use App\Contracts\RestFul\Ret\RetInterface;
use App\Http\Requests\IDRequest;
use App\Http\Requests\User\Goods\AddSectionsRequest;
use App\Http\Requests\User\Goods\IndexSectionsRequest;
use App\Http\Requests\User\Goods\SaveSectionsRequest;
use App\Lib\Parameter\LimitParam;
use App\Lib\Parameter\SortParam;
use App\Lib\Parameter\WhereParam;
use App\Lib\RetJson;
use App\Repositories\GoodsSection;

/**
 * 该类提供了后台端的商品属性增删改
 */
class AdminSectionsService
{
    /**
     * 增加商品属性
     *
     * @param AddSectionsRequest $request
     * @return RetInterface
     */
    public function addSections(AddSectionsRequest $request): RetInterface
    {
        //拿到要增加商品属性的信息
        //判断商品属性是否存在  
        // 存在：返回提示信息
        // 不存在：添加商品

        //1--拿到要增加商品的信息
        $id = $request->input('id');
        $title = $request->input('title');
        //2--判断商品是否存在 (不存在才执行后面，存在返回)
        $resTitle = GoodsSection::singleton()->getTitleBySectionTitle($title);
        //2.1--不存在
        if (!$resTitle) {
            //增加商品属性
            GoodsSection::singleton()->insertSections($id, $title);
            return RetJson::pure()->msg('添加成功');
        } else {
            return RetJson::pure()->msg('名称重复，请重新输入');
        }
    }

    /**
     * 删除商品属性
     *
     * @param IDRequest $request
     * @return RetInterface
     */
    public function deleteSections(IDRequest $request): RetInterface
    {
        //拿到要删除商品属性ID
        //直接删除
        //返回

        $ids = $request->input('id');
        GoodsSection::singleton()->deleteById($ids);
        return RetJson::pure()->msg('删除成功');
    }

    /**
     * 修改商品属性
     *
     * @param SaveSectionsRequest $request
     * @return RetInterface
     */
    public function saveSections(SaveSectionsRequest $request): RetInterface
    {
        $id = $request->input('id');
        $title = $request->input('title');
        if (!empty($title)) {
            GoodsSection::singleton()->UpdateById($id, $title);
        }
        return RetJson::pure()->msg('修改成功');
    }

    /**
     * 查询商品属性
     *
     * @param IndexSectionsRequest $request
     * @return RetInterface
     */
    public function getSections(IndexSectionsRequest $request): RetInterface
    {
        //需要--条件，查询数据，排序，分页
        //返回--list数据

        //分页
        list($limit) = (new LimitParam())->build();
        //排序
        $sp = (new SortParam());
        $sp->sort('id', 'desc');
        $sort = $sp->build();
        //条件查询
        list($where) = (new WhereParam())->compare('title')->build();
        //查询数据
        $sectionsList = GoodsSection::singleton()->getSectionsList($limit, $sort, $where);
        //返回
        return RetJson::pure()->list($sectionsList);
    }
}
