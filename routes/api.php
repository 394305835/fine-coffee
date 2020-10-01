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
        Route::namespace('User')->group(function () {
        });
        // 商家端
        Route::namespace('Business')->group(function () {
        });
        // 后台端
        Route::namespace('Admin')->group(function () {
            // 管理员管理
            // 管理员-列表
            // Route::get('/admin', 'AuthAdminController@index');
            // 管理员-新增
            Route::get('/admin', 'AuthAdminController@saveAdmin');
            // 管理员-编辑
            // Route::put('/admin', 'AuthAdminController@saveAdmin');
            // 管理员-删除
            // Route::delete('/admin', 'AuthAdminController@deleteAdmin');

            // 角色组
            // 角色组-列表
            // Route::get('/group', 'AuthGroupController@index');
            // 角色组-下拉列表
            // Route::get('/group/select', 'AuthGroupController@getSelect');
            // 角色组-新增
            // Route::post('/group', 'AuthGroupController@saveGroup');
            // 角色组-编辑
            // Route::put('/group', 'AuthGroupController@saveGroup');
            // 角色组-删除
            // Route::delete('/group', 'AuthGroupController@deleteGroup');

            // 访问规则管理
            // 访问规则-列表
            // Route::get('/rule', 'AuthRuleController@index');
            // 访问规则-下拉列表
            // Route::get('/rule/select', 'AuthRuleController@getSelect');
            // 访问规则-新增,只有 root 组才能操作
            // Route::post('/rule', 'AuthRuleController@saveRule');
            // Route::put('/rule', 'AuthRuleController@saveRule');
            // Route::delete('/rule', 'AuthRuleController@deleteRule');
            // 访问规则-状态改变
            // Route::put('/rule/status', 'AuthRuleController@changeRuleStatus');
        });
    });
});
