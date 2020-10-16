<?php

use App\Http\Controllers\Admin\AuthAdminController;
use App\Http\Controllers\User\LoginController;
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
    });
});

// 用户端
Route::namespace('User')->prefix('user')->middleware('cors')->group(function () {
    //登录
    Route::post('/login', 'LoginController@login');
    Route::post('/logout', 'LoginController@logout');
    Route::get('/sms', 'ApiController@getSMS');

    //用户商品查询(PS:不需要登录也可以查看商品)
    Route::get('/query', 'GoodsController@ ');



    Route::middleware('auth.user.api')->group(function () {
        // 获取用户个人信息
        Route::get('/info', 'UserController@getUserInfo');

        // // 用户-列表
        // Route::get('/list', 'UserController@index');
        // 用户-修改
        Route::put('/user', 'UserController@saveUser');
        // 用户-文件上传
        /**
         * 
         */
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

        //生成一条订单详情页
        Route::get('/confirm_order', 'OrderController@index');
        //商品订单--立即购买
        Route::post('/do_order', 'OrderController@createOrder');
    });

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

        //商品订单确认页
        Route::get('/confirm_order', 'OrderController@index');
    });
});

// 商家端
Route::namespace('Seller')->prefix('seller')->middleware('cors')->group(function () {
});
