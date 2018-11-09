<?php

namespace App\Models\Factory\Api;

use App\Models\Orm\VersionUpgrade;
use App\Models\Orm\VersionConfig;

/**
 * Class VersionFactory
 * @package App\Models\Factory\Api
 * 版本
 */
class VersionFactory extends ApiFactory
{
    /**
     * @param $data
     * @return array
     * Android —— 版本升级
     */
    public static function fetchVersion($platType, $appType)
    {
        $versionArr = VersionUpgrade::where(['status' => 1, 'plat_type' => $platType, 'app_type' => $appType])->first();

        return $versionArr ? $versionArr->toArray() : [];
    }

    /**
     * iOS Android 审核
     * @param array $params
     * @return array
     */
    public static function fetchIOSPeding($params = [])
    {
        $pending = VersionUpgrade::where(['plat_type' => $params['platType'], 'app_type' => $params['appType'], 'version_code' => $params['versionCode']])->first();

        return $pending ? $pending->toArray() : [];
    }

    /**
     * 获取APP是否审核
     *
     * @param array $params
     * @param $channel
     * @return array
     */
    public static function fetchUpgradeConfigInfo($params = [], $channel)
    {
        $pending = VersionConfig::where(['upgrade_id' => $params['id'], 'channel_nid' => $channel, 'status' => 1])->first();

        return $pending ? $pending->toArray() : [];
    }
}
