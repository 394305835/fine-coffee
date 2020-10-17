<?php

namespace App\Jobs;

use App\Model\DOrdereModel;
use App\Model\DShoppingCartModel;
use App\Repositories\Order;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class CreateOrderPodcast implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * 订单信息
     *
     * @var DOrdereModel
     */
    protected $order;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct(DOrdereModel $order)
    {
        $this->order = $order;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $bean = [
            'uuid' => $this->order->uuid,
            'seller_id' => $this->order->seller_id,
            'cart_id' => 1,
            'user_id' => $this->order->user_id,
            'goods_id' => 0,
            'lable_id' => 0,
            'pay_id' => $this->order->pay_id,
            'sections' => '',
            'pay_status' => Order::PAY_NO,
            'status' => Order::NORMAL,
            'place_time' => $this->order->place,
            'pay_time' => 0,
        ];

        // 如果订单已经过期，则直接插入过期订单
        if (time() > $this->order->etime) {
            $bean['pay_status'] = Order::PAY_CANCEL;
        }
        Order::singleton()->insert($bean);
    }
}
