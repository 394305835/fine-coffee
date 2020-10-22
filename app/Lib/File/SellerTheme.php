<?php

namespace App\Lib\File;

use App\Lib\Constans;
use Illuminate\Http\UploadedFile;

/**
 * 提供商户头像文件相关服务
 */
class SellerTheme extends FileService
{
    /**
     * Undocumented function
     *
     * @param string $path
     */
    public function __construct()
    {
        parent::__construct($this->changeClassNameToPath(__CLASS__));
        // "\user\theme"
    }

    /**
     * 判断文件是否是png 和jpg类型
     *
     * @Override
     * @param UploadedFile $file
     * @return boolean
     */
    public function verifFile(UploadedFile $file): bool
    {
        $rang = [Constans::MIME_IMAGE_JPEG, Constans::MIME_IMAGE_PNG];
        $type = $file->getClientMimeType();
        return in_array($type, $rang);
    }
}
