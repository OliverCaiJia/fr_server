<?php

namespace App\Services\Core\Message\OCR;

class FaceConfig
{
    // 域名
    const DOMAIN = PRODUCTION_ENV ? 'https://api.megvii.com' : 'https://api.megvii.com';

    const URI = '/faceid/v3/ocridcard';

    const APPKEY = PRODUCTION_ENV ? 'bAUfY44DsTVcJOlIjU3pL8NtDUltGz4A' : 'bAUfY44DsTVcJOlIjU3pL8NtDUltGz4A';

    const APPSECRET = PRODUCTION_ENV ? 'EPjP-uraLYTc-H6wfwy1e6kUxMTRypWH' : 'EPjP-uraLYTc-H6wfwy1e6kUxMTRypWH';

    public static function getUrl()
    {
        return static::DOMAIN . static::URI;
    }
}
