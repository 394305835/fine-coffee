<?php

namespace App\Lib\Parameter;

use App\Contracts\Parameter\RequestParameterInterface;
use App\Lib\Constans;

/**
 * 分页参数组装
 */
class LimitParam implements RequestParameterInterface
{
    protected $limit;

    public function build(): array
    {
        return $this->buildLimit();
    }

    public function buildLimit(): array
    {
        $request = request();
        if (!$this->isLimit($this->limit)) {
            $this->limit = (int) $request->input('limit', Constans::PAGE_LIMIT);
        }
        $offset = (int) $request->input('page', 1);
        return [$this->limit, $offset];
    }

    public function limit(int $limit = -1): self
    {
        if ($this->isLimit($limit)) {
            $this->limit = $limit;
        }
        return $this;
    }

    public function isLimit($limit): bool
    {
        return is_integer($limit) && $limit != -1 && $limit > 0;
    }
}
