<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class sync extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'command:sync';

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
        // 1.
        $a = [
            ['time' => 1],
            ['time' => 5],
            ['time' => 8],
            ['time' => 11],
            ['time' => 16],
            ['time' => 17],
            ['time' => 29],
            ['time' => 34],
            ['time' => 39],
        ];
        $time_line = [3, 7, 12, 17, 19, 31, 40];
        $count = count($a);
        $bean = [];
        $min = [];
        foreach ($time_line as $key => $value) {
            foreach ($a as $k => $v) {
                $bean[] = abs((int)$value - (int)$v['time']);
            }
            // dd($bean);
            $min = min($bean);
            //这个函数取出来对应value的第一个key值
            $key = array_search($min, $bean);
            $countv = 0;
            foreach ($bean as $key => $value) {
                if ($value == $min) {
                    $countv = $countv + 1;
                }
            }
            dd($key);
            dd($countv);
            // unset($bean);
        }
        foreach ($min as $key => $value) {
            dump($value);
        }



        // 2. 输入时间，找出3小时后的工作时间点,如果遇到休息时间，需要跳过（就是休息时间不计时）
        // 输入时间格式：2020-03-21 14:23:31
        // 输入时间范围：1900-01-01 00:00:00,2050-01-01 00:00:00
        // 工作时间：周一至周五，上午8:00至12:00，下午2:00,至18:00
        //  ！！！！请注意题目各种情况  ！！！！

        // 测试用例如：
        // 输入2020-03-20 14:23:31(星期五)， 返回 2020-03-20 17:23:31
        // 输入2020-03-20 05:23:31(星期五)， 返回 2020-03-20 11:00:00

        //  ！！！！把各种题目可能出现异常的测试用例情况，保存到代码后面！！！！

    }
}
