<?php

namespace App\Http\Controllers\Api\V1;

use App\Helpers\RestResponseFactory;
use App\Helpers\RestUtils;
use App\Http\Controllers\Api\ApiController;
use Illuminate\Http\Request;
use App\Services\Core\Payment\YiBao\YiBaoConfig;
use App\Services\Core\Payment\YiBao\YopSignUtils;


class YiBaoController extends ApiController
{
    /**
     * 获取账户信息
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public  function sync(Request $request)
    {
        $params = $request->get();
        file_put_contents('1.txt',$params);
    }

    public function async(Request $request)
    {
        $params = $request->all();
        $public_key = YiBaoConfig::YOP_PUBLIC_KEY;
        $private_key = YiBaoConfig::PRIVATE_KEY;
        $data = YopSignUtils::decrypt($params,$public_key,$private_key);
        file_put_contents('2.txt', $data);
    }
}