<?php

namespace App\Http\Services\User;

use App\Repositories\SKU;
use App\Contracts\RestFul\Ret\RetInterface;
use App\Http\Requests\User\OrderComfirmRequest;
use App\Http\Requests\User\OrderPayRequest;
use App\Lib\Constans;
use App\Lib\RetJson;
use App\Lib\Utils;
use App\Model\DOrdereModel;
use App\Model\DShoppingCartModel;
use App\Repositories\User\GoodsSign;
use App\Repositories\User\ShoppingCart;
use Illuminate\Support\Str;

/**
 * 用户商品购买流程
 * 
 * 1. 商品信息阶段
 *  1.1 每一次用户浏览商品，后台为用户与该商品之间生成一个唯一的下单的标识，该标识就是 用户 + 商品ID的标识
 *  1.2 后续步骤必须需要下单标识
 * 
 * 2. 购买阶段(为用户生成该商品唯一属性的购物车信息,用 DShoppingCartModel 的 uuid 方法区分商品唯一性)
 * 
 * 3. 支付阶段，当用户到购买阶段时，会让用户确认购物车信息
 *  3.1 无论成功失败，为用户创建一条订单，该订单为用户当前查看购物车信息的商品内容
 *  3.2 然后将订单分发给队列
 * 
 * 立即购买会占用一个商品库存，并且规则时间内支付，否则会 还库存
 * 加入购物车不同,不占用一个商品库存
 * 
 * 
 */
class OrderService extends UserBaseService
{
    /**
     * 获取用户购物商品时的购物车信息
     * 
     * 将生成的购物车信息携带到 RetInterface 中
     *
     * @param OrderComfirmRequest $request
     * @return RetInterface
     */
    public function getShoppingCart(OrderComfirmRequest $request): RetInterface
    {
        // 1--拿到要生成订单的TOKEN是否有效
        $goodsId = (int) $request->input('goods_id');
        $sign = $request->input('sign');

        $repo = GoodsSign::singleton(USER_UID);
        // 判断用户对应的商品 token 是否有有效
        if (!$repo->checkToken($goodsId, $sign)) {
            return RetJson::pure()->error('请刷新');
        }

        // 2--验证type_id是否有效
        $typeIds = $request->input('type_id');
        // FIXME:type_id验证后期需要修复 修复问题是  我们目前的做法是将商品所有的属性选择ID全部传过来
        // 应该按照一个section.id对应一个type.id来传数据(PS:前端给单选框也能实现，但是不太好)
        // if (!(new Section)->hasSectionType($goodsId, $typeIds)) {
        //     return RetJson::pure()->error('参数无效');
        // }

        //3--拿到商品信息
        // $goods = Goods::singleton('id', 'theme', 'name', 'price', 'is_sale')->getGoodsById($goodsId);
        // $sectionType = SectionType::singleton('title')->getGoodsByIds($typeIds)->pluck('title');

        $number = (int) $request->input('number');
        $price = 10;
        $discount = 0;
        $sectionType = "大/热/糖";

        // IMPROATANT: 购物车生成成功，删除商品下单唯一 token
        // 防止恶意下单，或重复下单
        $repo->remove($goodsId);


        // 4 并返回与购物车对应的数据
        return RetJson::pure()->entity(
            new DShoppingCartModel(
                USER_UID,
                $goodsId,
                $typeIds,
                $sectionType,
                $number,  // 购买数量
                $price,  // 单价
                $discount,   // 折扣,优惠金额
                0,  // 折扣后的单价
                10,  // 实际支付金额
                $sign
            )
        );
    }

    /**
     * 加入购物车
     *
     * @param OrderComfirmRequest $request
     * @return RetInterface
     */
    public function addToCart(OrderComfirmRequest $request): RetInterface
    {
        //生成一个购物车信息
        $ret = $this->getShoppingCart($request);
        $body = $ret->getBody();

        if (!empty($body['entity'])) {
            /** @var DShoppingCartModel */
            $shop = $body['entity'];
            // user_id=1,goods_id=1,type_id=1,2  用

            // 3.1--为用户创建一条购物车信息
            $repo = ShoppingCart::singleton(USER_UID);
            // 3.2 判断同样的购物车商品信息是否存在
            $oldShop = $repo->getShopById($shop->cart_id);
            // 3.3 同样的商品已经存在
            if ($oldShop) {
                // 3.3.1 判断上一次商品是否过期
                if (Utils::isExpired($oldShop->etime)) {
                    // 重新加入该同样的商品
                    // 3.5 加入购物车--新
                    $repo->create($shop);
                } else {
                    // 将之前的购物车商品数量累加
                    // NOTE: 如果交换位置会变成当前进入的确认页购买数量会累加
                    $oldShop->number += $shop->number;
                    $oldShop->etime = $shop->etime;
                    // 3.5 加入购物车--老
                    $repo->create($oldShop);
                }
            } else {
                $repo->create($shop);
            }
            // 3.4 处理金额
            // EXP: 折扣后商品单价 = 原单价 - 折扣金额
        }

        return $ret;
    }

    /**
     * 用户订单确认页面
     * 
     * BUYSTEP: 步骤二,每次点击都会为用户生成该商品购物车信息，然后返回估计订单(就是购物车一些相关的信息)
     * 
     * TODO:疑问？库存的问题，减库存是在哪个时机去减库存
     * 确认订单会占用库存,也就是进入到该页面之前会判断库存是否充足
     *
     * @param OrderComfirmRequest $request
     * @return RetInterface
     */
    public function comfirmOrder(OrderComfirmRequest $request): RetInterface
    {
        // 1--拿到要生成订单的TOKEN是否有效--代理
        // 2--验证type_id是否有效---代理
        // 3--生成订单相关的信息,得到购物车信息，并加入购物车
        $ret = $this->addToCart($request);
        $body = $ret->getBody();

        if (empty($body['entity'])) {
            return $ret;
        }

        /** @var DShoppingCartModel */
        $shop = $body['entity'];

        // TODO:严格验证商品库存
        // NOTE:规避超卖情况
        // 1. 查询库存数量
        if (!SKU::singleton()->checkSKU($shop->goods_id, $shop->number)) {
            return RetJson::pure()->error('商品库存不足');
        }
        return RetJson::pure()->entity($shop);
    }


    /**
     * 立即支付
     * 
     * BUYSTEP: 步骤三,用户携带购物车ID和支付ID，生成订单后续
     *
     * @param OrderPayRequest $request
     * @return RetInterface
     */
    public function payOrder(OrderPayRequest $request): RetInterface
    {
        $cartIds = $request->input('cart_id');
        // 1. 获取购物车信息，可能有多个
        $repo = ShoppingCart::factory(USER_UID);
        $shops = [];

        foreach ($cartIds as $_cartId) {
            $shop = $repo->getShopById($_cartId);
            if (!$shop) {
                // 404: 购买的购物车信息不存在
                return RetJson::make(404)->error('网络错误');
            }
            $shops[] = $shop;
        }

        // 商家信息
        $sellerId = 1;

        // 2.获取一个订单数据，好交给队列生成订单
        $place = time();
        // 订单过期时间，为当前时间开始起，截止到10分钟后
        $etime = $place + Constans::TIME_TEN_MINUTE;
        $order = new DOrdereModel(Str::uuid(), $sellerId, USER_UID, $place, $etime);
        $order->shopcart = $shops;
        $order->pay_id = (int) $request->input('pay_id');

        // (new \App\Jobs\CreateOrderPodcast($order))->handle();
        // 将订单入队列，交给队列生成订单
        \App\Jobs\CreateOrderPodcast::dispatch($order);
        // 然后让该订单10分钟后自动取消
        // PS:也可以让订单队列作这件事
        \App\Jobs\CancleOrderPodcast::dispatch($order->uuid, $etime);

        // 以上没有任何问题，需要将购物车该条购物车清掉
        $repo = ShoppingCart::factory(USER_UID);
        foreach ($cartIds as $_cartId) {
            $repo->remove($_cartId);
        }

        return RetJson::pure()->msg();
    }
}
