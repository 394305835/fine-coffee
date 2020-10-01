<?php

namespace App\Repositories;

use App\Contracts\Repositories\RepoLogInterface;
use App\Lib\Repository\MongoRepository;
use App\Model\MongDB\LogModel;
use App\Model\MongDB\Model;

class Log extends MongoRepository implements RepoLogInterface
{
    /**
     * 创建当前仓库的模型对象
     *
     * @Override
     * @return Model
     */
    public function makeModel(): Model
    {
        return LogModel::singleton();
    }

    /**
     * 写日志
     *
     * @Override
     * @param mixed $input
     * @param integer $level
     * @return void
     */
    public function write($input, int $level): bool
    {
        return $this->insert($input);
    }
}
