<?php

use App\Http\Controllers\Admin\AuthAdminController;
use App\Http\Controllers\User\LoginController;
use App\Http\Controllers\User\OrderController;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\URL;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
 */


//测试自动下单接口
Route::get('/test_buy', [OrderController::class, 'payOrder']);

Route::get('hello', function () {
    dd(URL::previous());
});

// 普通登录跨域接口
Route::middleware('cors')->group(function () {
    // 后台登录及登出
    Route::post('/admin/login', [AuthAdminController::class, 'login']);
    Route::post('/admin/logout', [AuthAdminController::class, 'logout']);

    //用户端登录与登出
    Route::post('/user/login', [LoginController::class, 'login']);
    Route::post('/user/logout', [LoginController::class, 'logout']);
    // 短信验证码
    Route::get('/user/sms', [\App\Http\Controllers\User\ApiController::class, 'getSMS']);

    // 商家端登录与登出
    Route::post('/seller/login', [\App\Http\Controllers\Seller\LoginController::class, 'login']);
    Route::post('/seller/logout', [\App\Http\Controllers\Seller\LoginController::class, 'logout']);

    //支付成功后回调接口
    Route::post('/notif_order', [\App\Http\Controllers\Net\ApiController::class, 'orderNotif']);
});

// 后台端
Route::namespace('Admin')->prefix('admin')->middleware(['cors', 'auth.admin.api'])->group(function () {
    //个人信息获取
    Route::get('/menus', 'ApiController@getMenus');
    // 用户-文件上传
    Route::post('/upload', 'ApiController@upAdminFile');

    // 后台权限
    Route::middleware('auth.admin.rule')->group(function () {
        Route::get('/info', 'AuthAdminController@getUserInfo');
        // 管理员管理
        // 管理员-列表
        Route::get('/admins', 'AuthAdminController@index');
        // 管理员-新增
        Route::post('/admin', 'AuthAdminController@saveAdmin');
        // 管理员-编辑
        Route::put('/admin', 'AuthAdminController@saveAdmin');
        // 管理员-删除
        Route::delete('/admin', 'AuthAdminController@deleteAdmin');

        // 角色组
        // 角色组-列表
        Route::get('/role', 'AuthGroupController@index');
        // 角色组-下拉列表
        Route::get('/role/select', 'AuthGroupController@getSelect');
        // 角色组-新增
        Route::post('/role', 'AuthGroupController@saveGroup');
        // 角色组-编辑
        Route::put('/role', 'AuthGroupController@saveGroup');
        // 角色组-删除
        Route::delete('/role', 'AuthGroupController@deleteGroup');

        // 访问规则管理
        // 访问规则-列表
        Route::get('/rule', 'AuthRuleController@index');
        // 访问规则-下拉列表
        Route::get('/rule/select', 'AuthRuleController@getSelect');
        // 访问规则-新增,只有 root 组才能操作
        Route::post('/rule', 'AuthRuleController@saveRule');
        Route::put('/rule', 'AuthRuleController@saveRule');
        Route::delete('/rule', 'AuthRuleController@deleteRule');
        // 访问规则-状态改变
        Route::put('/rule/status', 'AuthRuleController@changeRuleStatus');

        //后台商品增加
        Route::post('/goods', 'AdminGoodsController@addGoods');
        //后台商品删除
        Route::delete('/goods', 'AdminGoodsController@deleteGoods');
        //后台商品修改
        Route::put('/goods', 'AdminGoodsController@saveGoods');
    });
});

// 用户端

Route::namespace('User')->prefix('user')->middleware(['cors', 'auth.user.api'])->group(function () {

    // //用户商品查询(PS:不需要登录也可以查看商品)
    // Route::get('/query', 'GoodsController@ ');
    // 获取用户个人信息
    Route::get('/info', 'UserController@getUserInfo');

    // // 用户-列表
    // Route::get('/list', 'UserController@index');
    // 用户-修改
    Route::put('/user', 'UserController@saveUser');
    // 用户-头像上传
    Route::post('/upload', 'ApiController@upLoadFile');

    //配送地址管理增删改查
    //配送地址 -列表
    Route::get('/address', 'UserAddressController@index');
    //配送地址 -新增
    Route::post('/address', 'UserAddressController@addAddress');
    //配送地址 -修改
    Route::put('/address', 'UserAddressController@saveAddress');
    //配送地址 -删除
    Route::delete('/address', 'UserAddressController@deleteAddress');


    //获取商品详情信息-- 商品详情页面
    Route::get('/goods', 'GoodsController@getGoodsInfo');

    // 商品订单--立即购买-- 订单确认页面
    Route::post('/comfirm_order', 'OrderController@comfirmOrder');
    // 商品订单--立即支付--选择支付方式后付钱
    Route::post('/pay_order', 'OrderController@payOrder');
});

// 商家端
Route::namespace('Seller')->prefix('seller')->middleware(['cors', 'auth.seller.api'])->group(function () {
    // 头像上传
    Route::post('/upload', 'ApiController@upLoadTheme');

    // 商品信息获取
    Route::get('/goods', 'GoodsController@getGoodsList');
});
