<?php

namespace App\Console\Commands;

use App\Repositories\Sentences;
use Illuminate\Console\Command;

class CurlSentences extends Command
{
    /**
     * The name and signature of the console command.s
     *
     * @var string
     */
    protected $signature = 'sentences:curl';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = '采集句子';

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
     * @return mixed
     */
    public function handle()
    {
        $date = date('Y-m-d');
        $url = "http://sentence.iciba.com/index.php?callback=jQuery19003912201952171357_1599659747433&c=dailysentence&m=getdetail&title={$date}";
        $result = $this->sendHttp($url);

        preg_match('/(.+\()(.+)\)$/', $result, $array);
        $sentences = json_decode($array[2], 1);
        $repo = Sentences::singleton();
        $sentence = $repo->getSentenceByDate($sentences['title']);
        if ($sentence) {
                echo '该条句子已经存在';
                exit;
        } else {
            $data = [
                'english' => $sentences['content'],
                'chinese' => $sentences['note'],
                'theme' => $sentences['picture'],
                'voice' => $sentences['tts'],
                'date' => $sentences['title'],
                'from' => '金山'
            ];
            $repo->insert($data);
            echo "获取成功 \n";
            exit;
        }
        echo '获取失败';
        exit;
    }

    public function sendHttp($url)
    {
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'GET');
        curl_setopt($ch, CURLOPT_TIMEOUT, 60); //响应超时时间
        curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 5); // 连接超时时间
        $result = curl_exec($ch);
        return $result;
    }
}
