<?php

namespace App\Models\Factory\Api;

use App\Models\Orm\AccountPayment;
use App\Models\Orm\Platform;

class PlatformFactory extends ApiFactory
{

    public static function createPlatform($params)
    {
        $platformObj = new Platform();
        return $platformObj->save();
    }

    /**
     * 根据平台唯一标识获取平台信息
     * @param $platform_nid
     * @return mixed
     */
    public static function getPlatformByNid($platform_nid)
    {
        return Platform::select()->where('platform_nid', '=', $platform_nid)->get();
    }
}
