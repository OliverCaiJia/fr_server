<?php

namespace App\Helpers;

use App\Services\AppService;

class LinkUtils
{

    public static function getRand()
    {
        $rand = mt_rand(500000, 1200000);
        return $rand;
    }

    //分享落地页
    public static function shareLanding($invite_code = '')
    {
        return AppService::EVENT_URL . '/web/v1/invite/home?sd_invite_code=' . $invite_code;
    }
    //AppLogo
    public static function getLogo()
    {
        return AppService::App_Logo;
    }



}
