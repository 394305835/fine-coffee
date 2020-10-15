<?php

namespace App\Http\Services\User;

use App\Repositories\Goods;
use App\Repositories\SectionType;
use Illuminate\Database\Eloquent\Collection;

/**
 * 该类提供了订单详情确认页面查询功能
 */
class OrderService extends UserBaseService
{
    /**
     * 该方法提供了订单确认页面的的查询功能
     *
     * @param [type] $request
     * @return void
     */
    public function getOrderDetails($request)
    {
        //第一步拿到信息

        //需要的数据，商品ID 查询商品图片 属性选择 数量  价格
        $goodsId = $request->input('id');
        //用ID拿到商商品表中的信息
        $goodsList = Goods::singleton()->getGoodsByIds([$goodsId]);
    }
}
