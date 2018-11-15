<?php

namespace App\Http\Controllers\Api\V1;

use App\Helpers\RestResponseFactory;
use App\Helpers\RestUtils;
use App\Http\Controllers\Controller;
use App\Models\Factory\BanksFactory;
use App\Models\Factory\DeviceFactory;
use App\Strategies\BanksStrategy;
use Illuminate\Http\Request;

/**
 *推荐服务
 */
class GroomController extends Controller
{
    /**
     *推荐服务默认配置
     */
    public function default(Request $request)
    {
        return RestResponseFactory::ok();
    }
}