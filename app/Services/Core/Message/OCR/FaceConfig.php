<?php

namespace App\Services\Core\Message\OCR;

class FaceConfig
{
    // 域名
    const DOMAIN = PRODUCTION_ENV ? 'https://api.megvii.com' : 'https://api.megvii.com';

    const URI = '/faceid/v3/ocridcard';

    const APPKEY = PRODUCTION_ENV ? 'bAUfY44DsTVcJOlI' : 'bAUfY44DsTVcJO';

    const APPSECRET = PRODUCTION_ENV ? 'EPjP-uraLYTc-H6wf' : 'EPjP-uraLYTc-H6wfwy';

    public static function getUrl()
    {
        return static::DOMAIN . static::URI;
    }
}
