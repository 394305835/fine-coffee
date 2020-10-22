<?php

namespace App\Jobs;

use App\Model\DOrdereModel;
use App\Repositories\Order;
use App\Repositories\OrderCart;
use App\Repositories\SKU;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\DB;

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
        //2--插入order表信息

        $orderBean = [
            'uuid' => $this->order->uuid,
            'seller_id' => $this->order->seller_id,
            'user_id' => $this->order->user_id,
            'pay_id' => $this->order->pay_id,
            'pay_status' => Order::PAY_NO,
            'status' => Order::NORMAL,
            'place_time' => $this->order->place,
            'pay_time' => 0,
        ];

        // 如果订单已经过期，则直接插入过期订单
        if (time() > $this->order->etime) {
            $oldBean['pay_status'] = Order::PAY_CANCEL;
        }

        //3--插入order——cart表信息
        try {
            DB::beginTransaction();
            $orderId = Order::singleton()->insertGetId($orderBean);
            $orderCartBean = [];
            foreach ($this->order->shopcart as  $_shop) {
                //1--减少库存数量
                $bool = SKU::singleton()->decrementSKU($_shop->goods_id, $_shop->number);
                if (!$bool) {
                    // continue;
                }
                $temp = (array)$_shop;
                $temp['order_uuid'] = $this->order->uuid;
                $temp['order_id'] = $orderId;
                $orderCartBean[] = $temp;
            };
            OrderCart::singleton()->insert($orderCartBean);
            DB::commit();
        } catch (\Throwable $th) {
            dump($th);
            DB::rollBack();
            // TODO:mongoDB日志

        }
    }
}
