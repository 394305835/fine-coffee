<?php

namespace App\Http\Services\User;

use App\Contracts\RestFul\Ret\RetInterface;
use App\Http\Requests\User\CreateOrderRequest;
use App\Http\Services\User\Goods\Section;
use App\Jobs\CreateOrderPodcast;
use App\Lib\RetJson;
use App\Repositories\GoodsAccess;
use App\Repositories\OrderToken;
use App\Repositories\SectionType;

/**
 * 生成一条订单详情信息
 */
class OrderService extends UserBaseService
{
    /**
     * 该方法提供了订单确认页面的的查询功能
     *
     * @param [type] $request
     * @return void
     */
    public function getOrderDetails($request): RetInterface
    {

        $goodsId = $request->input('gid');
        $typeIds = $request->input('type_id');
        //用ID拿到商商品对应的信息，商品属性选择选中的选项
        $goodsList = SectionType::singleton()->getGoodsByIds($typeIds);
        return RetJson::pure()->entity($goodsList);
    }

    /**
     * 生成一个订单
     *
     * @param CreateOrderRequest $request
     * @return RetInterface
     */
    public function createOrder(CreateOrderRequest $request): RetInterface
    {
        // 1--拿到要生成订单的TOKEN是否有效
        // 2--验证type_id是否有效
        // 3--生成订单相关的信息--交给上面的方法做
        // 4--创建一个生成订单的队列任务
        // 5--返回该订单相关信息

        // 1--
        $gid = $request->input('gid');
        $typeIds = $request->input('type_id');
        $goodsId = OrderToken::singleton()->getToken($gid);
        if (!$goodsId) {
            return RetJson::pure()->msg('请刷新');
        }
        // 2--
        $section = new Section();
        if (!$section->hasSectionType($goodsId, $typeIds)) {
            return RetJson::pure()->msg('参数无效');
        }
        // 3--生成订单相关的信息
        $orderInfo = $this->getOrderDetails($request);

        //4--分发一条任务 把参数传给它，然后入队列
        CreateOrderPodcast::dispatch($orderInfo);

        //5-
        return RetJson::pure()->entity($orderInfo);
    }
}
