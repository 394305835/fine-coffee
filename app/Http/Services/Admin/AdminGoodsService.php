<?php

namespace App\Http\Services\Admin;

use App\Contracts\RestFul\Ret\RetInterface;
use App\Http\Requests\IDRequest;
use App\Http\Requests\User\Goods\AddGoodsRequest;
use App\Http\Requests\User\Goods\SaveGoodsRequest;
use App\Lib\RetJson;
use App\Repositories\Goods;
use App\Repositories\GoodsAccess;
use App\Repositories\SectionType;
use GMP;
use Illuminate\Support\Facades\DB;

/**
 * 该类提供了后台端的商品增删改
 */
class AdminGoodsService
{
    /**
     * 商品增加
     *
     * @param [type] $request
     * @return RetInterface
     */
    public function addGoods(AddGoodsRequest $request): RetInterface
    {
        //拿到要增加商品的信息
        //判断商品是否存在  
        //判断商品属性是否存在
        //判断商品属性选择是否存在
        //判断商品属性ID是否属于商品
        // 存在：返回提示信息
        // 不存在：添加商品

        //1--拿到要增加商品的信息
        $post = $request->only(array_keys($request->rules()));
        //2--判断商品是否存在 (不存在才执行后面，存在返回)
        $resGoods = Goods::singleton()->getGoodsNameOrsubTitle($post['name'], $post['subtitle']);
        //2.1--不存在
        if (!$resGoods) {
            //判断商品属性选择是否存在() 然后把对应的商品属性查出来--方便后面插表使用
            $typeIds = explode(',', $post['type_id']);
            $sectionIds = SectionType::singleton()->hasSectionType($typeIds);
            //返回集合取值用pluck()取
            $sectionIds = $sectionIds->pluck('section_id')->toArray();
            //将数组转换成为字符串 后面使用
            $sectionIds = implode(',', $sectionIds);
            if ($sectionIds) {
                DB::beginTransaction();
                try {
                    //增加商品(同时需要把其他一些关联的表给添加)
                    //涉及的表：1--商品表   2--关系表
                    $goodsId = Goods::singleton()->insertGoods($post);
                    GoodsAccess::singleton()->insertAccess($goodsId, $sectionIds, $post['type_id']);
                    DB::commit();
                    return RetJson::pure()->msg('添加成功');
                } catch (\Throwable $th) {
                    DB::rollBack();
                    return RetJson::pure()->throwable($th);
                }
            } else {
                //商品属性选择不存在，提示信息返回
                return RetJson::pure()->msg('商品属性选择不正确，请先添加商品属性选择后重试');
            }
        } else {
            return RetJson::pure()->msg('名称重复，请重新输入');
        }
    }

    /**
     * 商品删除
     *
     * @param [type] $request
     * @return RetInterface
     */
    public function deleteGoods(IDRequest $request): RetInterface
    {
        //拿到要删除商品的ID
        //删除商品与关联商品的表的记录
        //返回(无论成功与否都要返回成功)
        $goodsIds = $request->input('id');
        DB::beginTransaction();
        try {
            Goods::singleton()->deleteGoodsByGoodsId($goodsIds);
            GoodsAccess::singleton()->deleteAccessByGoodsId($goodsIds);
            DB::commit();
        } catch (\Throwable $th) {
            DB::rollBack();
            return RetJson::pure()->throwable($th);
        }
        return RetJson::pure()->msg('删除成功');
    }

    /**
     * 商品修改
     *
     * @param [type] $request
     * @return RetInterface
     */
    public function saveGoods(SaveGoodsRequest $request): RetInterface
    {
        /**
         * 1. 拿到要修改商品的ID
         * 2. 拿到商品要修改的信息
         * 3. 定义一个空数组，判断哪个字段有值，需要修改的,把值加到数组中去
         * 4. 将数据更新到数据库中去
         * 5. 返回提示信息
         */

        $goodsId = $request->input('id');
        $post = $request->only(array_keys($request->rules()));
        unset($post['id']);
        $bean = [];
        $data = [];
        if (!empty($post['theme'])) {
            $bean['theme'] = $post['theme'];
        }
        if (!empty($post['name'])) {
            $bean['name'] = $post['name'];
        }
        if (!empty($post['subtitle'])) {
            $bean['subtitle'] = $post['subtitle'];
        }
        if (!empty($post['price'])) {
            $bean['price'] = $post['price'];
        }
        if (!empty($post['section_id'])) {
            $data['section_id'] = $post['section_id'];
        }
        if (!empty($post['type_id'])) {
            $data['type_id'] = $post['type_id'];
        }
        DB::beginTransaction();
        try {
            Goods::singleton()->updateById($goodsId, $bean);
            GoodsAccess::singleton()->updateByGoodsId($goodsId, $data);
            DB::commit();
        } catch (\Throwable $th) {
            return RetJson::pure()->throwable($th);
            DB::rollBack();
        }
        return RetJson::pure()->msg('修改成功');
    }
}
