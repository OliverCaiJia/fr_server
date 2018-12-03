<?php

namespace App\Http\Controllers\Api\V1;

use App\Helpers\Logger\SLogger;
use App\Helpers\RestResponseFactory;
use App\Helpers\RestUtils;
use App\Http\Controllers\Api\ApiController;
use App\Models\Chain\Order\NoPayOrder\LoanOrder\DoApplyOrderHandler;
use App\Models\Chain\Order\PayOrder\PaidOrder\DoPaidOrderHandler;
use App\Models\Chain\Payment\PaymentAccount\DoPaymentAccountHandler;
use App\Models\Factory\Api\UserinfoFactory;
use App\Models\Factory\Api\UserOrderFactory;
use App\Strategies\UserOrderStrategy;
use Illuminate\Http\Request;
use App\Services\Core\Payment\YiBao\YiBaoConfig;
use App\Services\Core\Payment\YiBao\YopSignUtils;
use App\Models\Chain\Report\Scopion\DoReportOrderHandler;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

/**
 * Class YiBaoController
 * @package App\Http\Controllers\Api\V1
 * 易宝回调
 */
class YiBaoController extends ApiController
{
    /**
     * 易宝同步回调
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function sync(Request $request)
    {
        return 'ERROR';
    }

    /**
     * 易宝异步回调
     * @param Request $request
     * @return string
     */
    public function async(Request $request)
    {
        //获取回调结果
        $params = $request->input('response');
        //获取配置信息
        $public_key = YiBaoConfig::YOP_PUBLIC_KEY;
        $private_key = YiBaoConfig::PRIVATE_KEY;
        $resData = YopSignUtils::decrypt($params, $private_key, $public_key);
        $resData = json_decode($resData, true);
        //订单支付成功
        if ($resData['status'] != 'SUCCESS') {
            return 'ERROR';
        }
        //获取订单编号
        $data['order_no'] = $resData['orderId'];
        $userOrder = UserOrderFactory::getUserOrderByOrderNo($data['order_no']);
        if (empty($userOrder)) {
            return RestResponseFactory::ok(RestUtils::getStdObj(), '未找到该订单', 12345, '未找到该订单');
        }
        $orderType = UserOrderFactory::getOrderTypeNidByTypeId($userOrder['order_type']);
        UserOrderStrategy::getChainsByTypeNid($orderType['type_nid'], $data, $resData, $userOrder['user_id']);



    }
}