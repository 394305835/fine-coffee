<?php

namespace App\Model\MongDB;

use App\Contracts\Repository\BaseRepository;
use Jenssegers\Mongodb\Eloquent\Model as EloquentModel;

/**
 * 模型基类
 *
 */
class Model extends EloquentModel
{
    use BaseRepository;

    protected $connection = 'mongodb';
}
