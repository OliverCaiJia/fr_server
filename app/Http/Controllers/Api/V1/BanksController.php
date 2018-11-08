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
 * 银行卡设置
 */
class BanksController extends Controller
{
    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     * 银行卡添加
     */
    public function add(Request $request)
    {
        return RestResponseFactory::ok();
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     * 银行卡校验
     */
    public static function verify(Request $request)
    {
        return RestResponseFactory::ok();
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     * 银行卡删除
     */
    public function delete(Request $request)
    {
        return RestResponseFactory::ok();
    }

    /**
     * @return \Illuminate\Http\JsonResponse
     * 银行卡列表
     */
    public function list()
    {
        return RestResponseFactory::ok();
    }

    /**
     * @return \Illuminate\Http\JsonResponse
     * 修改默认银行卡
     */
    public function updateDefault(Request $request)
    {
        return RestResponseFactory::ok();
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     * 银行卡更新
     */
    public function update(Request $request)
    {
        return RestResponseFactory::ok();
    }


}