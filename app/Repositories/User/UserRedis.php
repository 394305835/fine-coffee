<?php

namespace App\Repositories\User;

use App\Lib\Repository\RedisRepository;

class UserRedis extends RedisRepository
{

    protected $tpl_key = "finecoffee:goods:user:%d";

    /**
     * 用户ID
     *
     * @var int
     */
    protected $uid;

    public function __construct(int $uid)
    {
        parent::__construct();
        $this->uid($uid);
    }

    /**
     * 连接模板 key
     * 
     * 为动态改变 uid 准备,该方法最好只调一次 
     *
     * @param string $staff
     * @return void
     */
    protected function concatTplKey(string $staff)
    {
        $this->tpl_key = $this->compose($this->tpl_key, $staff);
    }

    /**
     * 提供可动态改变 UID 的方法
     *
     * @param integer $uid
     * @return self
     */
    public function uid(int $uid): self
    {
        $this->uid = $uid;
        $this->key = sprintf($this->tpl_key, $uid);
        return $this;
    }
}
