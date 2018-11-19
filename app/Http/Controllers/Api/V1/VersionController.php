<?php

namespace App\Http\Controllers\Api\V1;

use App\Helpers\RestUtils;
use App\Strategies\VersionStrategy;
use Illuminate\Http\Request;
use App\Http\Controllers\Api\ApiController;
use App\Helpers\RestResponseFactory;
use App\Models\Factory\Api\VersionFactory;

class VersionController extends ApiController
{
    /**
     * @param Request $request
     * @return mixed
     * Android —— 版本升级
     */
    public function upgradeAndroid(Request $request)
    {
        //app来源
        $platType = $request->input('platType', 'android');
        //app产品来源
        $appType = $request->input('appType', 'sudaizhijia');
        //版本号
        $versionName = $request->input('versionName', '1.0.0');

        $versionData = VersionFactory::fetchVersion($platType, $appType);
        //不升级
        if (!$versionData) {
            return RestResponseFactory::ok(RestUtils::getStdObj(), RestUtils::getErrorMessage(3003), 3003);
        }
        //比较版本大小 数据梳理
        $version = VersionStrategy::getVersionAndroid($versionName, $versionData);

        return RestResponseFactory::ok($version);
    }

    /**
     * @param Request $request
     * Ios —— 版本升级
     */
    public function upgradeIos(Request $request)
    {
        //app来源
        $platType = $request->input('platType', 'ios');
        //app产品来源
        $appType = $request->input('appType', 'sudaizhijia');
        //版本号
        $versionName = $request->input('versionName', '1.0.0');

        $versionData = VersionFactory::fetchVersion($platType, $appType);

        //比较版本大小 数据梳理
        $version = VersionStrategy::getVersionIos($versionData);

        return RestResponseFactory::ok($version);
    }

}
