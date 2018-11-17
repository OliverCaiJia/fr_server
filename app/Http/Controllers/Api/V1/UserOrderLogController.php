<?php

namespace App\Http\Controllers\Api\V1;

use App\Helpers\RestResponseFactory;
use App\Helpers\RestUtils;
use App\Helpers\Utils;
use App\Http\Controllers\Api\ApiController;
use App\Models\Factory\Api\UserOrderFactory;
use App\Strategies\OrderStrategy;
use App\Strategies\UserOrderStrategy;
use Illuminate\Http\Request;

class UserOrderLogController extends ApiController
{
    /**
     * 创建log
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function create(Request $request)
    {
        $dataLog = $request->all();
        $dataLog['user_id'] = $this->getUserId($request);
        $orderTypeNid = $request->input('order_type_nid');
        $orderType = UserOrderFactory::getOrderTypeByTypeNid($orderTypeNid);
        $dataLog['order_type'] = $orderType['id'];
        $dataLog['product_id'] = $request->input('product_id', 0);
        $dataLog['channel_id'] = $request->input('channel_id', 0);
        $dataLog['channel_nid'] = $request->input('channel_nid', '');
        $dataLog['channel_title'] = $request->input('channel_title', '');

        $log = OrderStrategy::getDiffOrderTypeLog($dataLog);

        $res['product_id'] = $log['product_id'];
        if (isset($res['error'])) {
            return RestResponseFactory::ok(RestUtils::getStdObj(),RestUtils::getErrorMessage(1136),1136);
        }
        return RestResponseFactory::ok($res);
    }
}