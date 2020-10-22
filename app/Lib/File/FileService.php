<?php

namespace App\Lib\File;

use App\Lib\Utils;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Str;

/**
 * 提供文件相关服务.
 * 
 * 如果处理的是上传文件,则会将文件保存至项目根目录的 `storage/app/` 下
 */
class FileService
{
    /**
     * 当前处理文件的UUID
     *
     * @var string
     */
    protected $uuid;

    /**
     * 即将处理的文件路径
     *
     * @var string
     */
    protected $path;

    /**
     * 即将处理的文件名
     *
     * @var string
     */
    protected $filename;

    /**
     * 记录当前处理的文件是否处理完成
     *
     * @var bool
     */
    protected $finished;

    public function __construct(string $path = '')
    {
        $this->path = empty($path) ? 'public' : $path;
        // "\user\theme"
        $this->uuid = Str::uuid();
        $this->finished = false;
    }

    /**
     * 处理文件上传.
     *
     * @Override
     * @param UploadedFile $file 接收处理的文件
     * @return FilePath|null
     */
    public function upload(UploadedFile $file): ?FilePath
    {
        // 1. 明确保存文件的路径
        // 2. 保存文件
        // 3. 将文件所在相对路径返回回去
        //1 $path
        //  2 s
        // Storage::disk('local')->put('file.txt', 'Contents');

        //获取文件名的后缀名,得到一个新的文件名 "7f5126d7ea95e6672be941363230427c.png"
        $fileName = $this->parseFilenmae($file->getClientOriginalExtension());
        // Store the uploaded file on a filesystem disk with public visibility. PHP有这个方法直接调
        $realPath = $file->storePubliclyAs($this->path, $fileName);

        if ($realPath) {
            $this->finished = true;
            return new FilePath($realPath);
        }

        return null;
    }

    /** 
     * 解析出一个文件名.
     * 
     * 新的文件名解析格式: md5(当前文件保存路径 + 指定文件名) + 后缀名
     * 
     * @param string $fileExt 指定一个文件名的后缀
     * @return string
     */
    public function parseFilenmae(string $fileExt = ''): string
    {
        $fileName = $this->filename ? $this->filename : $this->uuid;
        // 拼接文件名
        $fileName = md5($this->path . $fileName);
        // 后缀名用md5包起来
        return $fileExt ? $fileName . '.' . $fileExt : $fileName;
    }

    /**
     * 设置当前处理的文件名
     *
     * @param string $fileName
     * @return self
     */
    public function setFilanme(string $fileName): self
    {
        $this->filename = $fileName;
        return $this;
    }

    /**
     * 当前处理的文件是否完成
     *
     * @return bool
     */
    public function isFinished(): bool
    {
        return $this->finished;
    }

    /**
     * 将类名转换成路径名
     *
     * @return string
     */
    protected function changeClassNameToPath($className): string
    {
        return Utils::toPath(Utils::getClassName($className));
        // Utils::getClassName($className)====== ' UserTheme'
        // Utils::toPath(Utils::getClassName($className))==="\user\theme"
    }

    /**
     * 验证文件是否有有效.
     * 
     * 具体应让每个子类单独实现
     *
     * @param UploadedFile $file
     * @return bool
     */
    public function verifFile(UploadedFile $file): bool
    {
        return true;
    }
}

/**
 * 1--接收要上传头像
 * 2--把这个头像保存起来
 * $this->savetheme($theme);
 * 
 * 3--返回头像在服务器上的地址
 * return 
 */
