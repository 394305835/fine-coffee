<?php

namespace App\Http\Services\User;

use App\Contracts\RestFul\Ret\RetInterface;
use App\Http\Requests\IDRequest;
use App\Lib\RetJson;
use App\Repositories\Category;
use App\Repositories\GoodsAccess;
use App\Repositories\GoodsToken;
use App\Repositories\SectionType;
use Illuminate\Database\Eloquent\Collection;

/**
 * 该类提供了用户端的商品类
 */
class GoodsService
{

    protected $Category;
    public function __construct()
    {
        $this->Category = new Category();
    }
    /**
     * 获取商品列表
     * 通过类别来显示商品
     *
     * @param [type] $request
     * @return RetInterface
     */
    public function getGoodsList($request): RetInterface
    {
        // // 整体逻辑--商品和类别--这里做完了，就查后面的两个连接，然后把需要的数据拼接到这里的查询结果来

        // //第一步   把类别查询出来
        $categoryList = Category::singleton('id', 'title', 'sort')->getListSort('sort', 'desc')->toArray();
        $categoryList = array_column($categoryList, null, 'id');
        // //拿到查询类别的ID
        $categoryIds = array_keys($categoryList);
        // //拿到类别的ID查询类别对应商品的信息，按照类别分类显示。groupBy()需要在get()后使用
        $goodsList = GoodsAccess::singleton()->getGoodsByCategoryIds($categoryIds);

        //第二步  1,2

        // 1--section与type关系
        $typeIds = [];
        foreach ($goodsList as $v) {
            //扁平化过程，将多维数组变成一维数组
            $v->type_id = explode(',', $v->type_id);
            $typeIds = array_merge($typeIds, $v->type_id);
        }
        //array_flip一次去重操作，也就是键值对互换位置，所以这个时候我们需要的值就在key  取key出来就行了。
        $typeIds = array_keys(array_flip($typeIds));
        $types = SectionType::singleton()->getTypeByIds($typeIds);

        // $a = [['typeid' => '1,2,3']];
        // foreach ($a as $v) {
        //     $v['typeid'] = explode(',', $v['typeid']);
        // }
        // dump($a);

        // $b = [(object)['typeid' => '1,2,3']];
        // foreach ($b as $v) {
        //     $v->typeid = explode(',', $v->typeid);
        // }
        // dd($b);

        //2--goods与section关系
        $goodsList = $goodsList->toArray();
        foreach ($goodsList as &$_goods) {
            //从categoryList中获取到相关的分类信息

            //从这里开始----
            // @TODO
            $_goods['sections'] = [];
            foreach ($types as $_type) {
                //判断当前遍历的type.id在不在商品type_id里面
                if (in_array($_type->id, $_goods['type_id'])) {
                    //如果存在，就把当前type信息追加到数组sections中
                    $_goods['sections'][] = $_type->toArray();
                    // array_push($_goods['sections'], $_type->toArray()); 上面效率高于下面
                }
            }
            unset($_goods['type_id']);
            //处理sections ->树形结构
            $a = new Collection($_goods['sections']);
            $_goods['sections'] = array_values($a->groupBy('section_id')->toArray());

            //第三步
            //将caterory与goods的关系分出来
            //获取当前商品对应的分类信息
            // $categoryList[$_goods['categroy_id']] = $categoryList[$_goods['categroy_id']];
            if (empty($categoryList[$_goods['category_id']]['goods'])) {
                $categoryList[$_goods['category_id']]['goods'] = [];
            }
            $categoryList[$_goods['category_id']]['goods'][] = $_goods;
        }
        return RetJson::pure()->list(array_values($categoryList));
    }

    /**
     * 获取商品信息
     *
     * BUYSTEP: 步骤一,获取商品信息，并生成该 商家+用户+商品 之间的唯一商品 token
     * 
     * @param IDRequest $request
     * @return RetInterface
     */
    public function getGoodsInfo(IDRequest $request): RetInterface
    {
        $goodsId = $request->input('id');
        //1--为当次页面刷新得到一个唯一的md5下单值
        
        $sign = GoodsToken::singleton()->create(USER_UID, $goodsId);
        return RetJson::pure()->entity([
            'id' => $goodsId,
            'sign' => $sign,
        ]);
    }
}


// 这个接口的目的就是把商品列表根据格式给返回出去。
// 数据表的结构设计。四张表的关系都在一个goodsAccess这个表里面  所以这个表是核心表，
// 排序根据sort来进行。设计到分组，只能在get()后使用，orderBy()也只能在get()后使用，  如果在集合前使用
// 那么使用的就是SQL的分组。不能达到我们目前的效果。还存在一个问题就是返回格式的时候
// 我们会把对应的值添加到数组后面去。比如goods表中 我们会去添加section_id字段，type_id字段
// 然后goods查询结果单独放一个键出来去接受section_id这个字段。也就是这个键对应一个数组。
// 然后再添加一个types 字段。去对应type_id这个字段。

// 分类 包着 商品 分别包着section_id,sections 

// 设计思路从大到小。
// 分类包含--商品列表--商品属性--（同级商品属性选择）
// 所以我们需要的数据有 分类类别，然后显示title字段。 不显示ID，显示名字
// 分类类别下面有商品列表 显示商品的信息，同时要包含商品的属性和属性选择的信息
// 商品对应的属性信息
// 商品对应的属性选择信息

// 分为两部分来做。
// 1---先把分类查询出来，然后排序。
// 2---把商品信息 对应的商品属性和属性的选择结构搭好
