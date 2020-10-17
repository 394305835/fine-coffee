<?php

namespace App\Jobs;

use App\Lib\Constans;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class CancleOrderPodcast implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * 订单全球唯一ID号
     *
     * @var string
     */
    protected $order_uuid;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct(string $order_uuid, int $etime)
    {
        $this->order_uuid = $order_uuid;
        // 延迟半小时取消订单
        $this->delay($etime);
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        // 具体取消订单的操作
    }
}
