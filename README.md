# 项目设计

## 系统架构

C/S 架构模型和 B/S 架构模式的组合

设计的端有 Web 端,主要提供后台管理。
移动端主要面向用户和商家
用户端：主要是使用商家提供的服务。
商家端：给用户提供服务，给平台提供数据。

## 功能

用户的收获地址里面的地址信息暂时直接输入

### 商品系统

-   订单系统

    -   出单系统
    -   购物车

    *   下单系统 -结算系统

-   商品信息

### 用户系统

-   登录
    -   手机号快速登录
    *   第三方登录
        -   微信登录

*   退出

## 项目基础

### 项目支持

1.服务器类型 linux 版本:7.0.2 2.语言的选型 PHP7.3.4
3.sql 的选型 mysql -- 所有实体数据均用 mysql 来存
4.nosql 的选型
4.1.项目日志 -- mongodb
4.2.用户数据，登录信息，缓存信息 -- redis 5.框架选型 -- laravel 7.0
6.HTTP 验证 -- Oauth2.0 JWT

### 用户端实现方式

1.小程序+后台功能 PS:见 UI 设计图
用户管理界面+用户界面功能实现
[
[
'id' => 1,
'name' => 大师咖啡
'msg' => 瑞幸必喝爆款
'sx'=>上心
'child'=>[
[
'good_id'=>1,
'name' => 大师咖啡
'cz'=> 5-3
'price'=>15
'number'=>0
],
[
'good_id'=>2,
'name' => 大师咖啡
],
[
'good_id'=>3,
'name' => 大师咖啡
],
[
'good_id'=>1,
'name' => 大师咖啡
],
[
'good_id'=>1,
'name' => 大师咖啡
],
[
'good_id'=>1,
'name' => 大师咖啡
]
]
],
[
'id' => 1,
'name' => 欢乐 N+1
]
]

### 商家端实现方式

1.React+后台功能 PS:见 UI 设计图
商家管理界面+商家界面功能实现

### 后台管理实现方式

1.VUE+后台功能 PS:见 UI 设计图
后台管理界面+管理界面功能实现
