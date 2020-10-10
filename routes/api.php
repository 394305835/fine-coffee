<?php

use Illuminate\Support\Facades\Route;
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

// 通常
Route::namespace('Sign')->middleware('cors')->group(function () {
    // Route::post('login', 'LoginController@login');
    // Route::post('logout', 'LoginController@logout');
});

//api
Route::namespace('Api')->middleware('cors')->group(function () {
    Route::namespace('V1')->prefix('v1')->group(function () {
        // 用户端
        Route::namespace('User')->prefix('user')->group(function () {
            //登录
            Route::post('/login', 'LoginController@login');
            Route::post('/logout', 'LoginController@logout');
            Route::get('/sms', 'ApiController@getSMS');

            Route::middleware('auth.user.api')->group(function(){
                // 用户-列表
                Route::get('/list', 'UserController@index');
                // 用户-新增
                Route::post('/user', 'UserController@saveUser');
    
                //配送地址管理增删改查
                //配送地址 -列表
                Route::get('/addresss', 'AddressController@index');
                //配送地址 -新增
                Route::post('/address', 'AddressController@saveAddress');
                //配送地址 -修改
                Route::put('/address', 'AddressController@saveAddress');
                //配送地址 -删除
                Route::delete('/address', 'AddressController@deleteAddress');
            })
        });


        // 商家端
        Route::namespace('Business')->group(function () {
        });


        // 后台端
        Route::namespace('Admin')->group(function () {
            //登录，退出
            Route::post('/login', 'AuthAdminController@login');
            Route::post('/logout', 'AuthAdminController@logout');

            //验证token访问的接口
            Route::middleware('auth.api')->group(function () {
                //验证API
                //个人信息获取
                Route::get('/info', 'AuthAdminController@getUserInfo');
                //验证权限
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
    });
});
