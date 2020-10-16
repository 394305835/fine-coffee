<?php

namespace App\Http\Services\User;

use App\Contracts\RestFul\Ret\RetInterface;
use App\Http\Requests\User\CreateOrderRequest;
use App\Http\Services\User\Goods\Section;
use App\Jobs\CreateOrderPodcast;
use App\Lib\Constans;
use App\Lib\RetJson;
use App\Model\ShoppingCartModel;
use App\Repositories\Goods;
use App\Repositories\OrderToken;
use App\Repositories\SectionType;
use App\Repositories\ShoppingCart;
use Illuminate\Support\Str;

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
    public function getOrderDetails(CreateOrderRequest $request): RetInterface
    {
        // 1--拿到要生成订单的TOKEN是否有效
        $gid = $request->input('gid');
        $typeIds = $request->input('type_id');
        $number = $request->input('number');
        $goodsId = OrderToken::singleton()->getToken($gid);
        if (!$goodsId) {
            return RetJson::pure()->msg('请刷新');
        }
        // 2--验证type_id是否有效
        // FIXME:type_id验证后期需要修复 修复问题是  我们目前的做法是将商品所有的属性选择ID全部传过来
        // 应该按照一个section.id对应一个type.id来传数据(PS:前端给单选框也能实现，但是不太好)
        $section = new Section();
        if (!$section->hasSectionType($goodsId, $typeIds)) {
            return RetJson::pure()->msg('参数无效');
        }

        //3--拿到商品信息
        $goods = Goods::singleton('id', 'theme', 'name', 'price', 'is_sale')->getGoodsById($goodsId);
        $sectionType = SectionType::singleton('title')->getGoodsByIds($typeIds)->pluck('title');
        $goods->type = $sectionType;
        $goods->number = $number;
        $goods->uuid = Str::uuid();
        $goods->type_id = $typeIds;
        return RetJson::pure()->entity($goods);
    }

    /**
     * 生成一个订单
     *
     * @param CreateOrderRequest $request
     * @return RetInterface
     */
    public function createOrder(CreateOrderRequest $request): RetInterface
    {
        // 1--拿到要生成订单的TOKEN是否有效--代理
        // 2--验证type_id是否有效---代理
        // 3--生成订单相关的信息--代理
        // 4--创建一个生成订单的队列任务
        // 5--返回该订单相关信息

        // 3--生成订单相关的信息
        $ret = $this->getOrderDetails($request);
        $orderInfo = $ret->getBody()['entity'];
        // 3.1--为用户创建一条购物车信息
        $repo = ShoppingCart::singleton();
        $shopCart = new ShoppingCartModel();
        $shopCart->uuid = $shopCart->createUUID(USER_UID, $orderInfo->id, $orderInfo->type_id);
        $shopCart->user_id = USER_UID;
        $shopCart->goods_id = $orderInfo->id;
        $shopCart->number = $orderInfo->number;
        $shopCart->begin_time = time();
        $shopCart->end_time = time() + Constans::TIME_HOUR;
        $shopCart->price = $orderInfo->price;
        $shopCart->type_id = $orderInfo->type_id;

        $repo->create($shopCart);
        //4--分发一条任务 把参数传给它，然后入队列
        CreateOrderPodcast::dispatch($orderInfo);

        //5-
        return RetJson::pure()->entity($orderInfo);
    }
}
