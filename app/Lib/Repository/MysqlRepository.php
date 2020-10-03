<?php

namespace App\Lib\Repository;

use App\Contracts\Repository\BaseRepository;
use App\Contracts\Repository\CreateRepository;
use App\Contracts\Repository\DeleteRepository;
use App\Contracts\Repository\ReadRepository;
use App\Contracts\Repository\UpdateRepository;
use App\Lib\Parameter\LimitParam;
use App\Lib\Parameter\SortParam;
use App\Lib\Parameter\WhereParam;
use App\Lib\Utils;
use App\Model\Mysql\Model;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Collection;

/**
 * 该类为操作 mysql 数据库的一个抽象.
 *
 * 实现了对数据库的增、删、改、查通用接口（部分）
 */
abstract class MysqlRepository implements ReadRepository, DeleteRepository, UpdateRepository, CreateRepository
{

    use BaseRepository;

    /**
     * 对应的模型对象
     *
     * @var Model
     */
    protected $model;

    /**
     * 默认查询字段
     *
     * @var array
     */
    protected $field = [];

    public function __construct(...$fields)
    {
        $this->model = $this->makeModel();
        $this->setField($fields ? $fields : ['*']);
    }

    /**
     * 由每外 dao 仓库自己实现返回一个模型对象
     *
     * @abstract
     * @return Model
     */
    abstract public function makeModel(): Model;

    /**
     * 为当前仓库设置查询时的字段
     *
     * @param array $fields
     * @return self
     */
    public function setField($fields = []): self
    {
        if ($fields) {
            $_fields = [];
            foreach ($fields as $fed) {
                if (is_array($fed)) {
                    $_fields = array_merge($_fields, $fed);
                    continue;
                }
                $_fields[] = $fed;
            }
            $this->field = $_fields;
        }
        return $this;
    }

    /**
     * 获取当次查询时的字段
     *
     * @param array $default
     * @return array
     */
    public function getField(array $default = []): array
    {
        return !empty($default) ? $default : $this->field;
    }

    /**
     * 过滤非表里面的字段名.
     *
     * 该方法会过滤掉 setField 设置后不属于对应模型表字段的查询字段
     *
     * @return static
     */
    public function filterField(): self
    {
        if (empty($this->field) || in_array('*', $this->field)) {
            $this->field = ['*'];
        } else {
            // 去掉非表里面的字段
            $this->field = Utils::intersect($this->model->getAttributes(), $this->field);
        }
        return $this;
    }

    /**
     * 快速使用 RequestParam 参数查询
     *
     * @param WhereParam $wp
     * @param SortParam $sp
     * @param LimitParam $lp
     * @return Collection|LengthAwarePaginator
     */
    public function getByRP(WhereParam $wp = null, SortParam $sp = null, LimitParam $lp = null)
    {
        $result = $this->model->query();

        if ($wp && $wp instanceof WhereParam) {
            list($where, $whereIn) = $wp->build();
            // 条件查询
            if ($where) {
                $result = $result->where($where);
            }
            if ($whereIn) {
                foreach ($whereIn as $_in) {
                    $result = $_in[1] === 'not'
                        ? $result->whereNotIn($_in[0], $_in[2])
                        : $result->whereIn($_in[0], $_in[2]);
                }
            }
        }

        // 排序
        if ($sp && $sp instanceof SortParam) {
            foreach ($sp->build() as $key => $sort) {
                $result = $result->orderBy($key, $sort);
            }
        }
        // 分页
        if ($lp && $lp instanceof LimitParam) {
            list($limit) = $lp->build();
            return $result->paginate($limit, $this->getField());
        }
        return $result->get($this->getField());
    }

    public function findByWhereParam(WhereParam $wp): ?Model
    {
        $where = $wp->buildCompare();
        return $where ? $this->model->query()->where($where)->first($this->field) : null;
    }

    public function findBy(string $field, $value, $columns = ['*']): ?Model
    {
        return $this->model->query()->where($field, $value)->first($this->getField($columns));
    }

    /**
     * 插入数据并返回该条记录的主ID
     *
     * @param array $bean
     * @return integer
     */
    public function insertGetId(array $bean): int
    {
        $bean[$this->model::CREATED_AT] = $bean[$this->model::UPDATED_AT] = time();
        return $this->model->query()->insertGetId($bean);
    }

    /** 接口方法 */

    /**
     * Undocumented function
     *
     * @Override
     * @return \Illuminate\Database\Eloquent\Collection|static[]
     */
    public function all()
    {
        return $this->model->query()->get($this->getField());
    }

    /**
     * Undocumented function
     *
     * @Override
     * @param integer $perPage
     * @param integer $offset
     * @return void
     */
    public function paginate(int $perPage, int $offset = 0)
    {
        return $this->model->query()->paginate($perPage, $this->field);
    }

    /**
     * Undocumented function
     *
     * @Override
     * @param array $where
     * @return boolean
     */
    public function delete(array $where): bool
    {
        // PS: model delete 返回的时受影响条件的int
        return !!$this->model->query()->where($where)->delete();
    }

    /**
     * Undocumented function
     *
     * @Override
     * @param array $where
     * @param array $bean
     * @return boolean
     */
    public function update(array $where, array $bean): bool
    {
        $bean[$this->model::UPDATED_AT] = time();
        // PS: model update 返回的时受影响条件的int
        return !!$this->model->query()->where($where)->update($bean);
    }

    /**
     * Undocumented function
     *
     * @Override
     * @param array $bean
     * @return boolean
     */
    public function insert(array $bean): bool
    {
        $bean[$this->model::CREATED_AT] = $bean[$this->model::UPDATED_AT] = time();
        return !!$this->model->query()->insert($bean);
    }
}
