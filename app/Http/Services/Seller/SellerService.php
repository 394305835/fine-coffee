<?php

namespace App\Http\Services\Seller;

use App\Contracts\RestFul\Ret\RetInterface;
use App\Http\Requests\IDsRequest;
use App\Http\Requests\Seller\SellerAddRequest;
use App\Http\Requests\Seller\SellerSaveRequest;
use App\Lib\RetJson;
use App\Repositories\Seller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

/**
 * 商家
 */
class SellerService
{
    /**
     * 当前登录商家信息
     *
     * @api
     * @param Request $request
     * @return PsrResponseInterface
     */
    public function getSellerInfo(Request $request): RetInterface
    {
        $repo = Seller::singleton();
        $SellerInfo = $repo->getSellerInfo();
        return RetJson::pure()->list($SellerInfo);
    }

    /**
     * 商家管理-商家-新增
     *
     * @param SellerSaveRequest $request
     * @param SellerService $service
     * @return PsrResponseInterface
     */
    public function addSeller(SellerAddRequest $request): RetInterface
    {
        /**
         * 1--拿到要新增的商家信息
         * 2--判断新增的商家信息是否存在
         * 3--存在  返回  不存在  新增操作
         */

        $post = $request->only(array_keys($request->rules()));
        unset($post['id']);
        $repo = Seller::singleton();
        $bool = $repo->getNumberOrUsernameById($post);
        if (!empty($bool)) {
            return RetJson::pure()->msg('商家编号或名字已经存在，无法添加');
        }
        DB::beginTransaction();
        try {
            $post['password'] = encrypt($post['password']);
            $repo->insert($post);
            DB::commit();
        } catch (\Throwable $th) {
            return RetJson::pure()->throwable($th);
            DB::rollBack();
        }
        return RetJson::pure()->list();
    }
    /**
     * 商家管理-商家-编辑
     *
     * @param SellerSaveRequest $request
     * @param SellerService $service
     * @return PsrResponseInterface
     */
    public function saveSeller(SellerSaveRequest $request): RetInterface
    {
        /**
         * 1--拿到要修改的信息
         * 2--判断修改的商家是否存在
         * 3--存在 判断是否有数据  允许修改   不存在 提示返回 
         * 目前只可以修改自己  使用的SELLER_UID
         */
        $post = $request->only(array_keys($request->rules()));
        if (empty($post)) {
            return RetJson::pure()->msg('修改成功');
        }
        unset($post['id']);
        $repo = Seller::singleton();
        $bool = $repo->getSellerById();

        if (empty($bool)) {
            return RetJson::pure()->msg('商家不存在');
        }
        $bean = [];
        foreach ($post as $k => $v) {
            if ($k == 'password') {
                $bean[$k] = encrypt($v);
            } else {
                $bean[$k] = $v;
            }
        }
        // if (!empty($post['theme'])) {
        //     $bean['theme'] = $post['theme'];
        // }
        // if (!empty($post['address'])) {
        //     $bean['address'] = $post['address'];
        // }
        // if (!empty($post['password'])) {
        //     $post['password'] = encrypt($post['password']);
        //     $bean['password'] = $post['password'];
        // }
        DB::beginTransaction();
        try {
            $repo->updateById(SELLER_UID, $post);
            DB::commit();
        } catch (\Throwable $th) {
            DB::rollBack();
            return RetJson::pure()->throwable($th);
        }
        return RetJson::pure()->msg('修改成功');
    }

    /**
     * 商家管理-商家-删除
     *
     * @param IDsRequest $request
     * @param SellerService $service
     * @return PsrResponseInterface
     */
    public function deleteSeller(IDsRequest $request): RetInterface
    {
        /**
         * 1--拿到要删除的ID
         * 2--判断ID是否存在
         * 3--执行操作 删除 OR 不删除  目前只可以删除自己  使用的SELLER_UID
         */
        $repo = Seller::singleton();
        $bool = $repo->getSellerById();
        if (!empty($bool)) {
            DB::beginTransaction();
            try {
                $repo->deleteById();
                DB::commit();
            } catch (\Throwable $th) {
                DB::rollBack();
                return RetJson::pure()->throwable($th);
            }
        }
        return RetJson::pure()->msg('删除成功');
    }
}
