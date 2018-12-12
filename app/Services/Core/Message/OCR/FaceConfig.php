<?php

namespace App\Services\Core\Message\OCR;

class FaceConfig
{
    // 域名
    const DOMAIN = PRODUCTION_ENV ? 'https://api.megvii.com' : 'https://api.megvii.com';

    const URI = '/faceid/v3/ocridcard';

//    const APPKEY = PRODUCTION_ENV ? 'bAUfY44DsTVcJOlIjU3pL8NtDUltGz4A' : 'i-EgIJJiMieGKRWTt55_T4I9xVIl8hmP';
    const APPKEY = 'bAUfY44DsTVcJOlIjU3pL8NtDUltGz4A';

//    const APPSECRET = PRODUCTION_ENV ? 'EPjP-uraLYTc-H6wfwy1e6kUxMTRypWH' : 'bYBRxiVg43eZQbKxMYkNnc6g-aZE-naT';
    const APPSECRET = 'EPjP-uraLYTc-H6wfwy1e6kUxMTRypWH';

    public static function getUrl()
    {
        return static::DOMAIN . static::URI;
    }
}
