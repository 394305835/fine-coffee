<?php

namespace App\Http\Services\Admin;

use App\Contracts\RestFul\Ret\RetInterface;
use App\Http\Requests\Goods\SkuRequest;
use App\Http\Requests\User\Goods\AddSkuRequest;
use App\Http\Requests\User\Goods\IndexSKUSRequest;
use App\Http\Requests\User\Goods\SaveSkuRequest;
use App\Lib\Parameter\LimitParam;
use App\Lib\Parameter\SortParam;
use App\Lib\Parameter\WhereParam;
use App\Lib\RetJson;
use App\Repositories\Goods;
use App\Repositories\SKU;

/**
 * 该类提供了后台端的商品库存增删改查
 */
class AdminSkuService
{
    /**
     * 增加商品库存
     *
     * @param AddSkuRequest $request
     * @return RetInterface
     */
    public function addSKU(AddSkuRequest $request): RetInterface
    {
        /**
         * 1--拿到需要的数据，商品的ID和增加的数量
         * 2--验证商品ID的有效性，是否存在该商品 存在--增加库存   不存在 返回
         */
        $goodsId = $request->input('id');
        $number = $request->input('number');
        if (!empty($goodsId)) {
            try {
                $res = Goods::singleton()->getGoodsById($goodsId);
            } catch (\Throwable $th) {
                return RetJson::pure()->throwable($th);
            }
            if (!empty($res)) {
                try {
                    SKU::singleton()->addGoodsSku($goodsId, $number);
                } catch (\Throwable $th) {
                    return RetJson::pure()->throwable($th);
                }
            }
            return RetJson::pure()->msg('商品参数错误，无法添加库存');
        }
        return RetJson::pure()->msg('添加商品库存成功');
    }

    /**
     * 减少商品库存
     *
     * @param SkuRequest $request
     * @return RetInterface
     */
    public function deleteSKU(SkuRequest $request): RetInterface
    {
        /**
         * 1--拿到需要的数据，商品的ID和减少的数量
         * 2--验证商品ID的有效性，是否存在该商品 存在-减少库存   不存在 返回
         */
        $goodsId = $request->input('id');
        $number = $request->input('number');
        if (!empty($goodsId)) {
            try {
                $res = Goods::singleton()->getGoodsById($goodsId);
            } catch (\Throwable $th) {
                return RetJson::pure()->throwable($th);
            }
            if (!empty($res)) {
                try {
                    SKU::singleton()->deleteGoodsSku($goodsId, $number);
                } catch (\Throwable $th) {
                    return RetJson::pure()->throwable($th);
                }
            }
            return RetJson::pure()->msg('商品参数错误，无法减少库存');
        }
        return RetJson::pure()->msg('减少商品库存成功');
    }

    /**
     * 修改商品库存
     *
     * @param SaveSkuRequest $request
     * @return RetInterface
     */
    public function saveSKU(SaveSkuRequest $request): RetInterface
    {
        /**
         * 1--拿到需要的数据，商品的ID和减少的数量
         * 2--验证商品ID的有效性，是否存在该商品 存在-减少库存   不存在 返回
         */
        $goodsId = $request->input('id');
        $number = $request->input('number');
        if (!empty($goodsId)) {
            try {
                $res = Goods::singleton()->getGoodsById($goodsId);
            } catch (\Throwable $th) {
                return RetJson::pure()->throwable($th);
            }
            if (!empty($res)) {
                try {
                    SKU::singleton()->updateGoodsSku($goodsId, $number);
                } catch (\Throwable $th) {
                    return RetJson::pure()->throwable($th);
                }
            }
            return RetJson::pure()->msg('商品参数错误，无法减少库存');
        }
        return RetJson::pure()->msg('减少商品库存成功');
    }

    /**
     * 获取商品库存
     *
     * @param SaveSkuRequest $request
     * @return RetInterface
     */
    public function getSKUS(IndexSKUSRequest $request): RetInterface
    {
        //分页
        list($limit) = (new LimitParam())->build();
        //排序
        $sp = new SortParam();
        $sp->sort('goods_id', 'desc');
        $sort = $sp->build();
        //条件
        list($where) = (new WhereParam)->compare('goods_id')->build();
        //数据
        $SKUList = SKU::singleton()->getAllSKU($limit, $sort, $where);
        //返回
        return RetJson::pure()->list($SKUList);
    }
}
