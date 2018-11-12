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
        $userOrder = UserOrderFactory::getOrderByUserId($userId)->toArray();
        $res = null;
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
        $userOrder = UserOrderFactory::getOrderDetailByOrderNoAndUserId($orderNo, $userId)->toArray();
        $res = null;
        foreach ($userOrder as $uOrder) {
            $res['info'][] = [
                "amount" => $uOrder->amount,
                "status" => $uOrder->status
            ];
        }
        return RestResponseFactory::ok($res);
    }

    public function create(Request $request)
    {
        $res = [
            "payurl" => "http://www.xxx.com",
            "fcallbackurl" => "http://uat.api.sudaizhijia.com/v1/users/payment/callback/yibao/syncallbacks?type=user_report"
        ];
        return RestResponseFactory::ok($res);
    }

//    /**
//     * 根据用户id和订单号更新订单状态，返回成功条数
//     * @param Request $request
//     * @return \Illuminate\Http\JsonResponse
//     */
//    public function updateStatus(Request $request)
//    {
//        $userId = $request->input('user_id');
//        $orderNo = $request->input('order_no');
//        $status = $request->input('status');
//        $res = UserOrderFactory::updateOrderByUserId($userId, $orderNo, $status);
//        return RestResponseFactory::ok($res);
//    }

    public function status(Request $request)
    {
        $userId = $request->input('user_id');
        $orderNo = $request->input('order_no');
        $userOrder = UserOrderFactory::getOrderStatusByUserIdOrderNo($userId, $orderNo)->toArray();
        $res = null;
        foreach ($userOrder as $uOrder) {
            $res['info'][] = [
                "status" => $uOrder['status']
            ];
        }
        return RestResponseFactory::ok($res);
    }
}