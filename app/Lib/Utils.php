<?php

namespace App\Lib;

class Utils
{

    /**
     * 过滤掉非 org 中的数组元素.
     * 主要用于保存数据是,接收的参数与表里面的字段不一致或多余
     *
     * @param array $org
     * @param array $ary
     * @return array
     */
    public static function intersect(array $org, array $ary): array
    {
        return array_values(array_intersect($org, $ary));
    }

    /**
     * 生成用户密码本解密密码，该密码不可逆(没有解密过程),密码只有用户自己知道.
     *
     * ``php md5(4 位数字明文 + 用户UID) = 密文```
     * 
     * @param integer $uid
     * @param string $plaint
     * @return string
     */
    public static function createDictCipher(int $uid, string $plaint): string
    {
        return md5($uid . $plaint);
    }
}
