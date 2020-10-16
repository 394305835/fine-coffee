<?php

namespace App\Console\Commands;

use App\Jobs\CreateOrderPodcast;
use App\Lib\RetJson;
use App\Lib\Utils;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Redis;

class test extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'test';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command test';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        while (true) {
            CreateOrderPodcast::dispatch('abcdefghijklmnopqrstuvwxyz');
            sleep(1);
        };

        //对象--
        //这是一个创建对象的手段。
        //1创建一个对象   2 返回对象在的地址
        // $retjson = new RetJson();
        // echo $retjson;
        // echo--语言结构--只能输出字符串
        // print()--语言结构--只能输出字符串
        // print($retjson);
        // print_r()--只能输出引用类型的方法
        // print_r($retjson);
        // var_dump()--支持任何类型
        // var_dump($retjson);

        // $b =  $retjson;
        // $a =  $b;
        // $a->id = 5;
        // dump($a);
        // dump($b);
        // dump($retjson);

        // // $retjson = 1;
        // // $b = $retjson;
        // // $a = $b;
        // // $a = 5;
        // // dump($a);
        // // dump($b);
        // // dump($retjson);


        // $retjson = [1, 2, 3];
        // $b = $retjson;
        // $a = $b;
        // $a[0] = 5;
        // dump($a);
        // dump($b);
        // dump($retjson);


        // $ret1 = new RetJson();
        // $ret2 = $ret1;
        // $a = [$ret1, $ret2];
        // foreach ($a as $_ret) {
        //     $_ret->id = 5;
        //     break;
        // }
        // var_dump($a);

        // $ret1 = new RetJson();
        // $ret2 = $ret1;
        // $ret3 = [[$ret1], [$ret2]];
        // // 当前遍历元素XXX   $ret1[0]
        // foreach ($ret3 as $_ret3) {
        //     $_ret3[0]->id = 5;
        //     $_ret3[1] = 5;
        //     break;
        // }
        // var_dump($ret3);


        return 0;
    }
}
