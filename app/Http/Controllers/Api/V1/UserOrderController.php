<?php

namespace App\Http\Controllers\Api\V1;

use App\Helpers\RestResponseFactory;
use App\Helpers\RestUtils;
use App\Helpers\UserAgent;
use App\Helpers\Utils;
use App\Http\Controllers\Api\ApiController;
use App\Models\Factory\Api\UserOrderFactory;
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
        $userId = UserOrderStrategy::getUserIdByXToken($request);
        if (empty($userId)) {
            return RestResponseFactory::ok(RestUtils::getStdObj(),RestUtils::getErrorMessage(1150),1150);
        }
        $userOrder = UserOrderFactory::getOrderByUserId($userId);
        if (empty($userOrder)) {
            return RestResponseFactory::ok(RestUtils::getStdObj(),RestUtils::getErrorMessage(1150),1150);
        }
        $res = [];
        foreach ($userOrder as $uOrder) {
            $res['list'][] = [
                "order_no" => $uOrder['order_no'],
                "order_type" => $uOrder['order_type'],
                "create_at" => $uOrder['create_at'],
                "amount" => $uOrder['amount'],
                "term" => $uOrder['term'],
                "status" => $uOrder['status']
            ];
        }
        return RestResponseFactory::ok($res);
    }

    /**
     * 根据订单编号和用户id获取订单详情
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function info(Request $request)
    {
        $userId = UserOrderStrategy::getUserIdByXToken($request);
        if (empty($userId)) {
            return RestResponseFactory::ok(RestUtils::getStdObj(),RestUtils::getErrorMessage(1128),1128);
        }
        $orderNo = $request->input('order_no');
        $userOrder = UserOrderFactory::getOrderDetailByOrderNoAndUserId($orderNo, $userId);
        if (empty($userOrder)) {
            return RestResponseFactory::ok(RestUtils::getStdObj(),RestUtils::getErrorMessage(1150),1150);
        }
        $res = [];
        foreach ($userOrder as $uOrder) {
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
        $data['user_id'] = UserOrderStrategy::getUserIdByXToken($request);
        if (empty($data['user_id'])) {
            return RestResponseFactory::ok(RestUtils::getStdObj(),RestUtils::getErrorMessage(1199),1199);
        }
        $data['order_type'] = $request->input('order_type');
        $data['terminal_nid'] = $request->input('terminal_nid');
        $data['platform_nid'] = '';
        $data['term'] = 0;
        $data['request_text'] = '';
        $data['response_text'] = '';
        $data['amount'] = $request->input('amount');
        $data['count'] = $request->input('count');
        $data['order_no'] = UserOrderStrategy::createOrderNo();
        $data['order_expired'] = '2018-8-9';//TODO::
        $data['user_agent'] = UserAgent::i()->getUserAgent();
        $data['create_ip'] = Utils::ipAddress();
        $data['update_ip'] = Utils::ipAddress();
        $data['create_at'] = date('Y-m-d H:i:s', time());
        $res['success'] = UserOrderFactory::createOrder($data);
        return RestResponseFactory::ok($res);
    }

    /**
     * 查询订单状态
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function status(Request $request)
    {
        $userId = UserOrderStrategy::getUserIdByXToken($request);
        if (empty($userId)) {
            return RestResponseFactory::ok(RestUtils::getStdObj(),RestUtils::getErrorMessage(1128),1128);
        }
        $orderNo = $request->input('order_no');
        $userOrder = UserOrderFactory::getOrderStatusByUserIdOrderNo($userId, $orderNo);
        if (empty($userOrder)) {
            return RestResponseFactory::ok(RestUtils::getStdObj(),RestUtils::getErrorMessage(1150),1150);
        }
        $res['info']['status'] = $userOrder['status'];
        return RestResponseFactory::ok($res);
    }
}