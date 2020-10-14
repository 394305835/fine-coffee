<?php

namespace App\Http\Services\User;

use App\Contracts\RestFul\Ret\RetInterface;
use App\Lib\RetJson;
use App\Lib\Tree;
use App\Repositories\Category;
use App\Repositories\CategoryAccess;
use App\Repositories\Goods;
use App\Repositories\SectionAccess;
use App\Repositories\TypeAccess;

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
        // $categoryList = Category::singleton('id', 'title', 'sort')->all()->toArray();
        // //拿到查询类别的ID
        // $categoryIds = array_column($categoryList, 'id');
        // //拿到类别的ID查询类别对应商品的信息，按照类别分类显示。groupBy()需要在get()后使用
        // $goodsList = CategoryAccess::singleton()->getGoodsByCategoryIds($categoryIds);
        // //取到商品的ID，后面要使用
        // $goodsIds = array_column($goodsList->toArray(), 'id');
        $goodsIds = [1, 2];

        //第二步
        //商品和商品属性  TODO 把对应关系的三坨数据都取出来。然后再处理
        //拿到所有商品的ID  上面已经取出来了，这里不需要了。回来改 $goodsIds==商品的ID
        //拿到商品和商品属性的对应关系
        $sections = SectionAccess::singleton()->getSectionByGoodsIds($goodsIds);
        // dump($sections->groupBy('goods_id')->toArray());
        // exit;
        //拿到sectionIds 下一个建立关系好使用
        $sectionIds = $sections->pluck('id')->toArray();
        dump($sections->groupBy('goods_id')->toArray());
        // dd(array_flip(array_flip($sectionIds)));

        //第三步
        //商品属性和商品属性选择 这个的sectionIds 在上面取出来了， $sectionIds
        $types = TypeAccess::singleton()->getTypeBySectionIds($sectionIds);
        dump($types->toArray());
        exit;



        // //继续按照类别分组
        // $goodsList = $goodsList->groupBy('category_id')->toArray();
        // // dd($goodsList);


        //商品属性和商品属性选择  
        // $type = TypeAccess::singleton()->getGoodsByTypeIds($goodsIds);
        // dump($sections->toArray());

        // $sectionsIds = array_column($sections->toArray(), 'id');
        // dd($sectionsIds);
        //这里取出来的格式不对，是一个ID对应一群section.id，这里是取出来是1对1的关系，应该是1对3,所以这里处理下
        // $goods = Tree::instance()->getChildren($sections, 0, $self, $child);
        // dd($goods);
        return RetJson::pure()->msg('成功');





        // $result = [];
        // foreach ($userGroupIds as $_groupId) {
        //     $subGroups = Tree::instance()->getChildren($allGroup, $_groupId, $self, $child);
        //     // FIXME:生成树形结构需要修改后面，这里就是手动组合数据
        //     if ($child && !empty($subGroups[1])) {
        //         $temp = array_shift($subGroups);
        //         $temp['child'] = $subGroups;
        //         $subGroups = $temp;
        //     }
        //     $result = array_merge($result, $subGroups);
        // }
    }
}
