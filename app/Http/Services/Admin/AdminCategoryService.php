<?php

namespace App\Http\Services\Admin;

use App\Contracts\RestFul\Ret\RetInterface;
use App\Http\Requests\IDRequest;
use App\Http\Requests\User\Goods\AddCategoryRequest;
use App\Http\Requests\User\Goods\IndexCategorysRequest;
use App\Http\Requests\User\Goods\SaveSectionsRequest;
use App\Http\Requests\User\Goods\SaveCategoryRequest;
use App\Lib\Parameter\LimitParam;
use App\Lib\Parameter\SortParam;
use App\Lib\Parameter\WhereParam;
use App\Lib\RetJson;
use App\Repositories\Category;

/**
 * 该类提供了后台端的商品分类增删改查
 */
class AdminCategoryService
{
    /**
     * 增加商品分类
     *
     * @param AddCategoryRequest $request
     * @return RetInterface
     */
    public function addCategory(AddCategoryRequest $request): RetInterface
    {
        //拿到要增加商品分类的信息
        //判断商品分类是否存在  
        // 存在：返回提示信息
        // 不存在：添加商品

        //1--拿到要增加商品分类的信息
        $title = $request->input('title');
        $sort = $request->input('sort');
        //2--判断商品是否存在 (不存在才执行后面，存在返回)
        $resTitle = Category::singleton('title')->getTitleByCategoryTitle($title);
        //2.1--不存在
        if (!$resTitle) {
            //增加商品分类
            Category::singleton()->insertCategory($title, $sort);
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
    public function deleteCategory(IDRequest $request): RetInterface
    {
        //拿到要删除商品分类ID
        //直接删除
        //返回
        $ids = $request->input('id');
        Category::singleton()->deleteById($ids);
        return RetJson::pure()->msg('删除成功');
    }

    /**
     * 修改商品属性
     *
     * @param SaveSectionsRequest $request
     * @return RetInterface
     */
    public function saveCategory(SaveCategoryRequest $request): RetInterface
    {
        $id = $request->input('id');
        $title = $request->input('title');
        $sort = $request->input('sort');
        if (!empty($title)) {
            Category::singleton()->UpdateById($id, $title, $sort);
        }
        return RetJson::pure()->msg('修改成功');
    }

    /**
     * 查询商品分类
     *
     * @param IndexCategorysRequest $request
     * @return RetInterface
     */
    public function getCategorys(IndexCategorysRequest $request): RetInterface
    {
        //分页
        list($limit) = (new LimitParam())->build();
        //排序
        $sp = new SortParam();
        $sp->sort('id', 'desc');
        $sort = $sp->build();
        //条件
        list($where) = (new WhereParam())->compare('title')->build();
        //数据
        $CategorysList = Category::singleton()->getCategorysList($limit, $sort, $where);
        //返回
        return RetJson::pure()->list($CategorysList);
    }
}
