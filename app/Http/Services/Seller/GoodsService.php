<?php

namespace App\Http\Services\Seller;

use App\Contracts\RestFul\Ret\RetInterface;
use App\Http\Requests\Seller\GoodsListRequest;
use App\Http\Services\User\Goods\Section;
use App\Lib\Parameter\LimitParam;
use App\Lib\RetJson;
use App\Repositories\Category;
use App\Repositories\GoodsCategoryAccess;
use Illuminate\Http\Request;

class GoodsService
{

    public function getGoodsList(Request $request): RetInterface
    {
        $categoryId = (int) $request->input('category', 0);

        list($limit) = (new LimitParam)->build();

        // 1.商品信息
        // 商品分页信息
        $goodsPaginate = GoodsCategoryAccess::singleton()->paginateGoodsByCategoryId($categoryId, $limit);
        if (empty($goodsPaginate->items())) {
            return RetJson::pure()->list($goodsPaginate);
        }

        // 商品集合信息
        $goodsCollection = $goodsPaginate->getCollection();
        $goodsIds = $goodsCollection->pluck('id')->toArray();
        // 分类信息
        $categoryIds = $goodsCollection->pluck('category_id')->toArray();
        $categorys = Category::singleton('id', 'title', 'sort')->getCategoryByIds($categoryIds)->pluck('title', 'id', 'sort')->toArray();
        // 3.商品属性信息
        $goodsTypes = (new Section)->getGoodsTypeByGoodsIds($goodsIds);
        $goodsTypes = array_column($goodsTypes->toArray(), null, 'goods_id');

        // 将商品属性信息 添加到商品信息中
        foreach ($goodsCollection as $_goods) {
            $_goods->sections = $goodsTypes[$_goods->id]['sections'];
            $_goods->category = $categorys[$_goods->category_id];
        }

        return RetJson::pure()->list($goodsPaginate);
    }
}
