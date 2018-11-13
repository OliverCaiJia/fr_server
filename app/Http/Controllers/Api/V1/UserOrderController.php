<?php

namespace App\Http\Controllers\Api\V1;

use App\Helpers\RestResponseFactory;
use App\Http\Controllers\Api\ApiController;
use App\Models\Factory\Api\UserOrderFactory;
use Illuminate\Http\Request;

class UserOrderController extends ApiController
{
    /**
     * 根据用户id获取订单列表
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function list(Request $request)//
    {
        $userId = $request->input('user_id');
        $userOrder = UserOrderFactory::getOrderByUserId($userId);
        $res = [];
        foreach ($userOrder as $uOrder) {
            $res['list'][] = [
                "order_no" => $uOrder['order_no'],
                "create_at" => $uOrder['create_at'],
                "amount" => $uOrder['amount'],
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
        $userId = $request->input('user_id');
        $orderNo = $request->input('order_no');
        $userOrder = UserOrderFactory::getOrderDetailByOrderNoAndUserId($orderNo, $userId);
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
        $userId = $this->getUserId($request);
        $data['user_id'] = $userId;
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
        $userId = $this->getUserId($request);
        $orderNo = $request->input('order_no');
        $userOrder = UserOrderFactory::getOrderStatusByUserIdOrderNo($userId, $orderNo);
        $res['info']['status'] = $userOrder['status'];
        return RestResponseFactory::ok($res);
    }
}