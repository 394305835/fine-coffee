<?php

namespace App\Model\Mysql;

use App\Contracts\Repository\BaseRepository;
use Illuminate\Database\Eloquent\Model as EloquentModel;

/**
 * 模型基类
 *
 */
class Model extends EloquentModel
{
    use BaseRepository;

    // /**
    //  * 维护时间为时间戳
    //  *
    //  * @link https://carbon.nesbot.com/docs/
    //  * @var string
    //  */
    // protected $dateFormat = 'U';

    /**
     * 获取当前模型的 attributes
     *
     * @override
     * @return array
     */
    public function getAttributes()
    {
        return $this->attributes;
    }
}
