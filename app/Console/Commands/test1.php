<?php

namespace App\Console\Commands;

use App\Lib\RetJson;
use Illuminate\Console\Command;
use PhpParser\Node\Expr\Cast\Array_;

class test1 extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'test1';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

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
        $a = '{"uuid":"0f4667b3-a6be-4b5b-86f9-89539011c5d9","displayName":"App\\Jobs\\CreateOrderPodcast","job":"Illuminate\\Queue\\CallQueuedHandler@call","maxTries":null,"maxExceptions":null,"delay":null,"timeout":null,"timeoutAt":null,"data":{"commandName":"App\\Jobs\\CreateOrderPodcast","command":"O:27:\"App\\Jobs\\CreateOrderPodcast\":9:{s:8:\"\u0000*\u0000order\";i:10;s:3:\"job\";N;s:10:\"connection\";N;s:5:\"queue\";N;s:15:\"chainConnection\";N;s:10:\"chainQueue\";N;s:5:\"delay\";N;s:10:\"middleware\";a:0:{}s:7:\"chained\";a:0:{}}"},"id":"J07lrDtZE3LX72axt1CTkWSEhGxzGDKo","attempts":0}';
        dd(unserialize($a));
        // $ret = new RetJson();
        // $ret->name = $ret;
        // $ret->age = 20;
        // $ret->name->age = 20;
        // $ret->getName()->age = 20;
        // dump($ret);

        // $ret = [];
        // $ret[0] = new RetJson();
        // $ret[1] = [new RetJson()];
        // $ret[1][0]->name = 'gx';


        // $ret[1][0] = new RetJson();
        // $ret[1][0] = $ret[0];


        // $ret = [
        //     'id' => 1,
        //     'age' => 23,
        // ];

        // $ret['name'] = ['gx', 'ax', 'bx'];

        // $ret['son'] = [];
        // $ret['son']['son1'] = [
        //     'id' => 1,
        //     'age' => 23,
        //     'name' => 'qlover',
        // ];

        // $ret['son']['son2'] = new RetJson();


        $money = [
            ['id' => 1, 'money' => 100],
            ['id' => 2, 'money' => 200],
            ['id' => 3, 'money' => 300],
        ];

        $goods = [
            ['id' => 1, 'money_id' => 1, 'name' => 'gx111', 'section' => '1,2,3'],
            ['id' => 2, 'money_id' => 2, 'name' => 'gx222', 'section' => '4,5,6'],
            ['id' => 3, 'money_id' => 4, 'name' => 'gx333', 'section' => '7,8,9'],
        ];

        $array = [];
        foreach ($goods as  $v) {
            $v['money'] = 0;
            foreach ($money as  $value) {
                if ($v['money_id'] == $value['id']) {
                    $v['money'] = $value['money'];
                }
            }
            array_push($array, $v);
        }
        dd($array);

        $money = [
            ['id' => 1, 'money' => 100],
            ['id' => 2, 'money' => 200],
            ['id' => 3, 'money' => 300],
        ];

        $goods = [
            ['id' => 1, 'money_id' => 1, 'name' => 'gx111', 'section' => '1,2,3'],
            ['id' => 2, 'money_id' => 2, 'name' => 'gx222', 'section' => '4,5,6'],
            ['id' => 3, 'money_id' => 4, 'name' => 'gx333', 'section' => '7,8,9'],
        ];

        foreach ($goods as $k => $v) {
            foreach ($money as $key => $value) {
                if ($goods[$k]['money_id'] == $money[$key]['id']) {
                    $goods[$k]['moneys'] = $money[$key]['money'];
                }
            }
        }

        $goods = [
            ['id' => 1, 'money_id' => 1, 'name' => 'gx111', 'section' => '1,2,3'],
            ['id' => 2, 'money_id' => 2, 'name' => 'gx222', 'section' => '4,5,6'],
            ['id' => 3, 'money_id' => 4, 'name' => 'gx333', 'section' => '7,8,9'],
        ];
        //第一种--取地址修改
        foreach ($goods as  &$v) {
            $v['title'] = $v['id'] + $v['money_id'];
        }
        //第二种，取key值
        foreach ($goods as $k => $v) {
            $goods[$k]['title'] = $v['id'] + $v['money_id'];
        }

        for ($i = 0; $i < count($goods); $i++) {
            $goods[$i]['title'] = $goods[$i]['id'] + $goods[$i]['money_id'];
        }
        //第三种--利用中间变量去存储
        $temp = [];
        foreach ($goods as  $v) {
            $v['title'] = $v['id'] + $v['money_id'];
            $v['section'] = explode(',', $v['section']);
            array_push($temp, $v);
        }
        dump($temp);

        return 0;
    }
}
