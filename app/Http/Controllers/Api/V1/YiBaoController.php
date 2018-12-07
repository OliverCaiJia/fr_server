<?php

namespace App\Http\Controllers\Api\V1;

use App\Helpers\Logger\SLogger;
use App\Http\Controllers\Api\ApiController;
use App\Models\Factory\Api\UserOrderFactory;
use App\Strategies\UserOrderStrategy;
use Illuminate\Http\Request;
use App\Services\Core\Payment\YiBao\YiBaoConfig;
use App\Services\Core\Payment\YiBao\YopSignUtils;

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

        SLogger::getStream()->error('========================');
        SLogger::getStream()->error(json_encode($resData));
        SLogger::getStream()->error('========================');
        //订单支付成功
        if ($resData['status'] != 'SUCCESS') {
            return 'ERROR';
        }
        //获取订单编号
        $data['order_no'] = $resData['orderId'];
        SLogger::getStream()->error('========================');
        SLogger::getStream()->error(json_encode($data['order_no']));
        SLogger::getStream()->error('========================');
        $userOrder = UserOrderFactory::getUserOrderByOrderNo($data['order_no']);
        if (empty($userOrder)) {
            return 'ERROR';
        }
        $orderType = UserOrderFactory::getOrderTypeNidByTypeId($userOrder['order_type']);
        if (empty($orderType)) {
            return 'ERROR';
        }
        //todo::需确定后，进行优化
        return UserOrderStrategy::getChainsByTypeNid($orderType['type_nid'], $data, $resData, $userOrder['user_id']);
    }
}