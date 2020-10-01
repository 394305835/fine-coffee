<?php

namespace App\Repositories;

use App\Contracts\Repositories\RepoSentencesInterface;
use App\Lib\Repository\MysqlRepository;
use App\Model\Mysql\Model;
use App\Model\Mysql\SentencesModel;

class Sentences extends MysqlRepository implements RepoSentencesInterface
{
    /**
     * 创建当前仓库的模型对象
     *
     * @Override
     * @return Model
     */
    public function makeModel(): Model
    {
        return SentencesModel::singleton();
    }
    /**
     * 用date获取表中一条句子.
     *
     * @param string $date
     * @return SentencesModel|null
     */
    public function getSentenceByDate(string $date): ?SentencesModel
    {
        return $this->findBy('date',$date);
    }
}
