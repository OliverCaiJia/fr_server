<?php

namespace App\Strategies;

use App\Strategies\AppStrategy;

/**
 * Invite公共策略
 *
 * Class UserStrategy
 * @package App\Strategies
 */
class VersionStrategy extends AppStrategy
{
    /**
     * @param $versionName
     * @param array $versionData
     * Android —— 版本升级
     */
    public static function getVersionAndroid($versionName,$versionData = [])
    {
        $compare = version_compare($versionName, $versionData['version_code'], '<');
        if ($compare) {
            $is_upload = $versionData['type'];
        } else {
            $is_upload = 0;
        }
        $version                    = [];
        $version['is_upload'] = $is_upload;
        $version['is_show'] = $versionData['pending'];
        $version['version_code'] = $versionData['version_code'];
        $version['app_url'] = isset($versionData['apk_url']) ? $versionData['apk_url'] : '';
        $version['app_url_type'] = isset($versionData['apk_url_type']) ? $versionData['apk_url_type'] : 1;
        $version['upgrade_point'] = isset($versionData['upgrade_point']) ? $versionData['upgrade_point'] : '';

        return $version;
    }

    /**
     * @param $versionName
     * @param array $versionData
     * @return array
     * Ios —— 版本升级
     */
    public static function getVersionIos($versionName,$versionData = [])
    {
        $compare = version_compare($versionName, $versionData['version_code'], '<');

        if ($compare) {
            $is_upload = $versionData['type'];
        } else {
            $is_upload = 0;
        }
        $data = [];
        $data['is_upload'] = $is_upload;
        $data['is_show'] = $versionData['pending'];
        $data['version_code'] = $versionData['version_code'];
        $data['app_url'] = isset($versionData['apk_url']) ? $versionData['apk_url'] : '';
        $data['app_url_type'] = isset($versionData['apk_url_type']) ? $versionData['apk_url_type'] : 1;
        $data['upgrade_point'] = isset($versionData['upgrade_point']) ? $versionData['upgrade_point'] : '';

        return $data;
    }
}
