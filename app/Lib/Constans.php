<?php

namespace App\Lib;

/**
 * 该类提供了常量定义
 */
class Constans
{
    const PAGE_LIMIT = 10;

    const REGX_PHONE = '/^[1]([3-9])[0-9]{9}$/';

    const TIME_SECOND = 1; // 一秒
    const TIME_MINUTE = 60; // 一分钟
    const TIME_HOUR = 3600; // 一小时 60 * 60
    const TIME_HALF_HOUR = 1800; // 半小时 60 * 60 / 2
    const TIME_DAY = 86400; // 一天 60 * 60 * 24
    const TIME_TEN_MINUTE = 600; // 十分钟
    const TIME_TWENTY_MINUTE = 1200; // 二十分钟

    const TOKEN_EXP_TIME = 604800; // 86400 * 7 = 7天

    const MIME_IMAGE_PNG = 'image/png';    //PNG图片类型
    const MIME_IMAGE_JPEG = 'image/jpeg';   //JPEG图片

    const GOODS_SHOP_MAX_NUMBER = 40; // 购物车数量总数
}
