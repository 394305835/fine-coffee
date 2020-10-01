<?php

namespace App\Lib\Repository;

use App\Contracts\Repository\BaseRepository;
use App\Contracts\Repository\CreateRepository;
use App\Model\MongDB\Model;

/**
 * 该类为操作 MongoDB 的一个抽象.
 *
 */
abstract class MongoRepository implements CreateRepository
{
    use BaseRepository;

    /**
     * 对应的模型对象
     *
     * @var Model
     */
    protected $db;

    public function __construct(...$fields)
    {
        $this->db = $this->makeModel();
    }

    public function getDb()
    {
        return $this->db;
    }

    /**
     * 由每外 dao 仓库自己实现返回一个模型对象
     *
     * @abstract
     * @return Model
     */
    abstract public function makeModel(): Model;

    /**
     * Undocumented function
     *
     * @param array $bean
     * @return boolean
     */
    public function insert(array $bean): bool
    {
        return $this->db->insert($bean);
    }
}
