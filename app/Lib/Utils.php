<?php

namespace App\Lib;

/**
 * 工具类库
 */
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

    /**
     * 获取一个某个类的类名（不是全路径，只有类名）
     *
     * @param string $class
     * @return string
     */
    public static function getClassName(string $class_): string
    {
        //   \\两个反斜杠表示转义的意思(我们这里写一个表示特殊的)
        $cs = explode('\\', $class_);
        // array:4 [
        //     0 => "App"
        //     1 => "Lib"
        //     2 => "File"
        //     3 => "UserTheme"
        //   ]
        //取数组的最后一个函数
        return end($cs);
    }

    /**
     * 返回一个字符串组成的路径
     * 
     * 目前只支撑驼峰命名的字符串
     *
     * @param string $path
     * @return string
     */
    public static function toPath(string $path): string
    {
        //空串代表一个一个分隔
        $path = str_split($path);
        $result = '';
        foreach ($path as $word) {
            //获取一个字符的ascll码
            $str = ord($word);
            if ($str > 64 && $str < 91) {
                //strtolower($str) 转换为小写字母
                $result = $result . DIRECTORY_SEPARATOR . strtolower($word);
                continue;
            }
            $result = $result . $word;
        }
        return $result;
    }
}
