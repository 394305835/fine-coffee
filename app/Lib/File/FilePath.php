<?php

namespace App\Lib\File;

use Illuminate\Support\Facades\URL;

class FilePath
{
    /**
     * 保存文件后的相对路径,可能包括文件名
     *
     * @var string
     */
    protected $path;

    public function __construct(string $realPath)
    {
        $this->path = $realPath;
    }

    /**
     * 获取基础路径
     *
     * @return string
     */
    public function getPath(): string
    {
        return $this->path;
    }

    public function getPublicRealPath()
    {
        return $this->concat('upload', $this->path);
    }

    /**
     * 获取当前根目录下 stroage 中的相对路径
     *
     * @return string
     */
    public function getStroageRealPath(): string
    {
        return $this->concat('strage', $this->path);
    }

    /**
     * 获取http访问路径
     *
     * @return string
     */
    public function getUrl(): string
    {
        preg_match('/(.+\/\/)([^\/]+)/', URL::previous(), $result);
        return $this->concat($result[0], $this->getPublicRealPath());
    }

    /**
     * 连接路径
     *
     * @param string $path
     * @param string $staff
     * @return string
     */
    public static function concat(string $path, string $staff): string
    {
        return $path . DIRECTORY_SEPARATOR . $staff;
    }
}
