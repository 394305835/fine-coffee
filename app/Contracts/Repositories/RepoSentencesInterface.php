<?php

namespace App\Contracts\Repositories;
use App\Model\Mysql\SentencesModel;

interface RepoSentencesInterface
{
    /**
     * 用date获取表中一条句子.
     *
     * @param string $date
     * @return SentencesModel|null
     */
    public function getSentenceByDate(string $date): ?SentencesModel;

}
