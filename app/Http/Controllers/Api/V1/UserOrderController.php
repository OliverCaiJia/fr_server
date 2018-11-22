<?php

namespace App\Http\Controllers\Api\V1;

use App\Helpers\RestResponseFactory;
use App\Helpers\RestUtils;
use App\Helpers\Utils;
use App\Http\Controllers\Api\ApiController;
use App\Models\Factory\Api\UserOrderFactory;
use App\Models\Factory\FeeFactory;
use App\Strategies\OrderStrategy;
use App\Strategies\UserOrderStrategy;
use Illuminate\Http\Request;

class UserOrderController extends ApiController
{
    /**
     * 根据用户id获取订单列表
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function list(Request $request)
    {
        $userId = $this->getUserId($request);
        $userOrder = UserOrderFactory::getOrderAndTypeLogoByUserId($userId);
        $res = [];
        foreach ($userOrder as $uOrder) {
            if ($uOrder['status'] != 3 || $uOrder['status'] != 4) {
                $res[] = [
                    "order_no" => $uOrder['order_no'],
                    "order_type" => $uOrder['order_type'],
                    "create_at" => $uOrder['create_at'],
                    "amount" => $uOrder['amount'],
                    "term" => $uOrder['term'],
                    "logo_url" => $uOrder['logo_url'],
                    "status" => $uOrder['status']
                ];
            }
        }
        return RestResponseFactory::ok($res);
    }

    /**
     * 报告fee
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function report()
    {
        $feeNid = 'CREDIT_COST_DEFAULT';
        $result = FeeFactory::getFeeByFeeNid($feeNid);
        $res = [];
        $res['name'] = $result['name'];
        $res['remark'] = $result['remark'];
        $res['price'] = $result['price'];
        $res['old_price'] = $result['old_price'];
        return RestResponseFactory::ok($res);
    }

    /**
     * 额外fee
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function extra(Request $request)
    {
        $feeNid = 'CREDIT_GROOM_DEFAULT';
        $result = FeeFactory::getFeeByFeeNid($feeNid);
        $res = [];
        $res['name'] = $result['name'];
        $res['remark'] = $result['remark'];
        $res['price'] = $result['price'];
        $res['old_price'] = $result['old_price'];
        return RestResponseFactory::ok($res);
    }

    /**
     * 根据订单编号和用户id获取订单详情
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function info(Request $request)
    {
        $userId = $this->getUserId($request);
        $orderNo = $request->input('order_no');
        $userOrder = UserOrderFactory::getUserOrderByOrderNo($orderNo);
        $orderType = UserOrderFactory::getOrderTypeById($userOrder['order_type']);
        $info = OrderStrategy::getDiffOrderTypeInfo($userId, $orderNo, $orderType['type_nid']);
        $res = [];
        foreach ($info as $uOrder) {
            $res['info'][] = [
                "amount" => $uOrder['amount'],
                "status" => $uOrder['status']
            ];
        }
        return RestResponseFactory::ok($res);
    }

    /**
     * 创建订单
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function create(Request $request)
    {
        $data = $request->all();
        $data['user_id'] = $this->getUserId($request);
        $data['order_no'] = UserOrderStrategy::createOrderNo();
        //TODO::  A订单类型方法
        $orderTypeNid = $request->input('order_type_nid');
        $orderType = UserOrderFactory::getOrderTypeByTypeNid($orderTypeNid);
        $data['order_type'] = $orderType['id'];
        $data['order_expired'] = date('Y-m-d H:i:s', strtotime('+1 hour'));
        $data['amount'] = $request->input('amount');
        $data['term'] = $request->input('term', 0);
        $data['count'] = 1;
        $data['status'] = 0;
        $data['create_ip'] = Utils::ipAddress();
        $data['create_at'] = date('Y-m-d H:i:s', time());
        $data['update_ip'] = Utils::ipAddress();
        $data['update_at'] = date('Y-m-d H:i:s', time());
        $data['platform_nid'] = $request->input('platform_nid', '');

        $result = OrderStrategy::getDiffOrderTypeChainCreate($data);
        if (isset($result['error'])) {
            return RestResponseFactory::ok(RestUtils::getStdObj(), $result['error'], $result['code'], $result['error']);
        }
        $res = [];
        $res['order_no'] = $result['order_no'];
        $res['status'] = $result['status'];
        $res['order_type_nid'] = $orderTypeNid;
        $res['order_expired'] = $result['order_expired'];
        return RestResponseFactory::ok($res);
    }

    /**
     * 查询订单状态
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function getStatus(Request $request)
    {
        $userId = $this->getUserId($request);
        $orderNo = $request->input('order_no');
        $userOrder = UserOrderFactory::getOrderByUserIdOrderNo($userId, $orderNo);
        $res['info']['status'] = $userOrder['status'];

        $res['info']['order_no'] = $userOrder['order_no'];
        $res['info']['status'] = $userOrder['status'];
//        $res['info']['order_type_nid'] = $orderTypeNid;
        $res['info']['order_expired'] = $userOrder['order_expired'];
        return RestResponseFactory::ok($res);
    }

    /**
     * 更新订单
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(Request $request)
    {
        $data = $request->all();
        $data['user_id'] = $this->getUserId($request);
        $data['order_no'] = $request->input('order_no');
        $orderTypeNid = $request->input('order_type_nid');
        $orderType = UserOrderFactory::getOrderTypeByTypeNid($orderTypeNid);
        $data['order_type'] = $orderType['id'];
        $data['payment_log_id'] = $request->input('payment_log_id', 0);
        $data['order_expired'] = date('Y-m-d H:i:s', strtotime('+1 hour'));
        $data['amount'] = $request->input('amount');
        $data['term'] = $request->input('term', 0);
        $data['count'] = $request->input('count');
        $data['status'] = $request->input('status', 0);
        $data['create_ip'] = Utils::ipAddress();
        $data['create_at'] = date('Y-m-d H:i:s', time());
        $data['update_ip'] = Utils::ipAddress();
        $data['update_at'] = date('Y-m-d H:i:s', time());
        $data['platform_nid'] = $request->input('platform_nid', '');

        $order = OrderStrategy::getDiffOrderTypeChainForUpdate($data);
//        $res['order_no'] = $order['order_no'];
        if (isset($res['error'])) {
            return RestResponseFactory::ok(RestUtils::getStdObj(), RestUtils::getErrorMessage(1141), 1141);
        }
        return RestResponseFactory::ok($order);
    }


}