<?php

namespace App\Http\Controllers\Api\V1;

use App\Helpers\Logger\SLogger;
use App\Http\Controllers\Api\ApiController;
use App\Models\Factory\Api\UserOrderFactory;
use App\Services\Core\Payment\YiBao\YiBaoService;
use App\Strategies\UserOrderStrategy;
use Illuminate\Http\Request;

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
        $params = $request->input();
        if (!isset($params['data']) || !isset($params['encryptkey'])) {
            return 'ERROR';
        }
        $resData = YiBaoService::i()->undoData($params['data'], $params['encryptkey']);

        SLogger::getStream()->info('========================');
        SLogger::getStream()->info(json_encode($resData));
        SLogger::getStream()->info('========================');
        //订单支付成功
        if ($resData['status'] != 1) {
            return 'ERROR';
        }
        //获取订单编号
        $data['order_no'] = $resData['orderid'];
        SLogger::getStream()->info('========================');
        SLogger::getStream()->info(json_encode($data['order_no']));
        SLogger::getStream()->info('========================');
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
