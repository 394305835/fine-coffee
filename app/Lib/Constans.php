<?php

namespace App\Lib;

class Constans
{
    const PAGE_LIMIT = 10;

    const REGX_PHONE = '/^[1]([3-9])[0-9]{9}$/';

    const TIME_SECOND = 1; // 一秒
    const TIME_MINUTE = 60; // 一分钟
    const TIME_HOUR = 3600; // 一小时 60 * 60
    const TIME_DAY = 86400; // 一天 60 * 60 * 24

    const TOKEN_EXP_TIME = 604800; // 86400 * 7 = 7天
}
