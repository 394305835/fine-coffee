<?php

namespace Tests\Feature;

use App\Repositories\Goods;
use App\Repositories\GoodsAccess;
use App\Repositories\Token\UserToken;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class BuyGoodsTest extends TestCase
{
    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function testExample()
    {
        $token = UserToken::singleton()->getToken(1);
        $goodsId = 1;

        // 步骤一
        $response = $this->get("/api/user/goods?id={$goodsId}", ['Authorization' => $token]);
        $entity = $response->json('entity');
        $sign = $entity['sign'];

        // 步骤二
        $goodsTypeIds = [1, 2, 3, 4];
        $type_id = array_rand(array_flip($goodsTypeIds), 3);
        $body = [
            'sign' => $sign,
            'goods_id' => $goodsId,
            'type_id' => $type_id,
            'number' => rand(1, 10) // 购买数量 
        ];
        // dump($body);
        $response = $this->post("/api/user/comfirm_order", $body, ['Authorization' => $token]);
        $data = $response->json();
        $cartIds = [$data['entity']['cart_id']];
        // 第三步
        $body = [
            'cart_id' => $cartIds,
            'pay_id' => rand(1, 3) // 支付方式
        ];
        // dump($body);
        $response = $this->post("/api/user/pay_order", $body, ['Authorization' => $token]);
        $data = $response->json();
        dump($data);

        $response->assertStatus(200);
    }
}
