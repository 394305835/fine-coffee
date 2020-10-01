<?php

namespace App\Contracts\Service\Access;

use App\Contracts\RestFul\Ret\RetInterface;
use Illuminate\Http\Request;

interface EntityServiceInterface
{
    /**
     * 获取列表型实体数据
     *
     * @param Request $request
     * @return RetInterface
     */
    public function getList(Request $request): RetInterface;

    /**
     * 下拉列表型的实体数据
     *
     * @param Request $request
     * @return RetInterface
     */
    public function getSelect(Request $request): RetInterface;
}

