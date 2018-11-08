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
 *banner
 */
class BannerController extends Controller
{
    /**
     *推荐服务轮播图
     */
    public function groom(Request $request)
    {
        return RestResponseFactory::ok();
    }
}