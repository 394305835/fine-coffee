<?php

namespace App\Contracts\Parameter;

/**
 * 请求参数接口
 */
interface RequestParameterInterface
{
    /**
     * 构建查询条件，排序条件等从参数给起来可给模型使用的条件数组
     *
     * @return array
     */
    public function build(): array;
}
