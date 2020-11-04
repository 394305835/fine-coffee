<?php

namespace App\Http\Services\Admin;

use App\Contracts\RestFul\Ret\RetInterface;
use App\Http\Requests\IDRequest;
use App\Http\Requests\User\Goods\AddTypeRequest;
use App\Http\Requests\User\Goods\IndexTypesRequest;
use App\Http\Requests\User\Goods\SaveSectionsRequest;
use App\Http\Requests\User\Goods\SaveTypeRequest;
use App\Lib\Parameter\LimitParam;
use App\Lib\Parameter\SortParam;
use App\Lib\RetJson;
use App\Repositories\SectionType;

/**
 * 该类提供了后台端的商品属性增删改
 */
class AdminTypeService
{
    /**
     * 增加商品属性
     *
     * @param AddTypeRequest $request
     * @return RetInterface
     */
    public function addType(AddTypeRequest $request): RetInterface
    {
        //拿到要增加商品属性选择的信息
        //判断商品属性选择是否存在  
        // 存在：返回提示信息
        // 不存在：添加商品

        //1--拿到要增加商品的信息
        $id = $request->input('id');
        $post = $request->only(array_keys($request->rules()));
        unset($post['id']);
        //2--判断商品是否存在 (不存在才执行后面，存在返回)
        $resTitle = SectionType::singleton()->getTitleByTypeTitle($post['title']);
        //2.1--不存在
        if (!$resTitle) {
            //增加商品属性选择
            SectionType::singleton()->insertType($id, $post);
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
    public function deleteType(IDRequest $request): RetInterface
    {
        //拿到要删除商品属性选择ID
        //直接删除
        //返回

        $ids = $request->input('id');
        SectionType::singleton()->deleteById($ids);
        return RetJson::pure()->msg('删除成功');
    }

    /**
     * 修改商品属性
     *
     * @param SaveSectionsRequest $request
     * @return RetInterface
     */
    public function saveType(SaveTypeRequest $request): RetInterface
    {
        $id = $request->input('id');
        $post = $request->only(array_keys($request->rules()));
        if (!empty($title)) {
            SectionType::singleton()->UpdateById($id, $post);
        }
        return RetJson::pure()->msg('修改成功');
    }

    /**
     * 查询商品属性选择
     *
     * @param IndexTypesRequest $request
     * @return RetInterface
     */
    public function getTypes(IndexTypesRequest $request): RetInterface
    {
        //分页
        list($limit) = (new LimitParam())->build();
        //排序
        $sp = new SortParam();
        $sp->sort('id', 'desc');
        $sort = $sp->build();
        $typesList = SectionType::singleton()->getTypesList($limit, $sort);
        if (!empty($request->input('title'))) {
            $typesList->where('title', $request->input('title'));
        }
        return RetJson::pure()->list(($typesList->toArray()));
    }
}
