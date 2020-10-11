<?php

namespace App\Lib\File;

use App\Lib\Utils;
use Illuminate\Http\UploadedFile;

/**
 * 提供文件相关服务
 */
class FileService
{

    protected $path;

    /**
     * Undocumented function
     *
     * @param string $path
     */
    public function __construct(string $path = '')
    {
        $this->path = empty($path) ? 'public' : $path;
    }
    /**
     * 提供文件上传服务
     *
     * @param UploadedFile $file
     * @return string 返回文件所在服务器相对路径
     */
    public function up(UploadedFile $file, string $mark = ''): string
    {
        // 1. 明确保存文件的路径
        // 2. 保存文件
        // 3. 将文件所在相对路径返回回去
        //1 $path
        //  2 
        // Storage::disk('local')->put('file.txt', 'Contents');
        //获取文件名的后缀名
        $entension = $file->getClientOriginalExtension();
        // 有文件名就拼上mark  给默认文件名 当前时间戳+随机字符串
        $fileName = $mark ? $mark : time();
        //拼接文件名+后缀名用md5包起来
        $fileName = md5($this->path . $fileName) . '.' . $entension;
        $realPath = $file->storePubliclyAs($this->path, $fileName);
        return $realPath ? $this->padPath('upload', $realPath) : '';
    }


    public function down()
    {
        # code...
    }

    /**
     * 将类名转换成路径名
     *
     * @return string
     */
    protected function changeClassNameToPath($className): string
    {
        return Utils::toPath(Utils::getClassName($className));
    }


    /**
     * 填充路径
     *
     * @param string $path
     * @return string
     */
    public function padPath(string $prefix, string $path): string
    {
        if ($path[0] !== DIRECTORY_SEPARATOR) {
            return $prefix . DIRECTORY_SEPARATOR . $path;
        }
        return $prefix . $path;
    }
}
