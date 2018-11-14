<?php

namespace App\Models\Factory\Api;

use App\Constants\UserVipConstant;
use App\Helpers\UserAgent;
use App\Helpers\Utils;
use App\Models\Orm\Platform;
use App\Models\Orm\UserAuth;
use App\Models\Orm\UserOrder;
use App\Models\Orm\UserOrderType;

/**
 * Class UserOrderFactory
 * @package App\Models\Factory\Api
 */
class UserOrderFactory extends ApiFactory
{
    /**
     * 创建订单
     * @param $params
     * @return bool
     */
    public static function createOrder($params)
    {
        $userOrderObj = new UserOrder();
        $userOrderObj->user_id = $params['user_id'];
        $userOrderObj->order_no = $params['order_no'];
        $userOrderObj->order_expired = $params['order_expired'];//读配置
        $userOrderObj->order_type = $params['order_type'];
        $userOrderObj->terminal_nid = $params['terminal_nid'];
        $userOrderObj->platform_nid = $params['platform_nid'];
        $userOrderObj->term = $params['term'];
        $userOrderObj->request_text = $params['request_text'];
        $userOrderObj->response_text = $params['response_text'];
        $userOrderObj->amount = $params['amount'];
        $userOrderObj->count = $params['count'];
        $userOrderObj->user_agent = $params['user_agent'];
        $userOrderObj->create_ip = $params['create_ip'];
        $userOrderObj->update_ip = $params['update_ip'];
        $userOrderObj->create_at = $params['create_at'];
        return $userOrderObj->save();
    }

    /**
     * 根据用户id和订单号更新订单状态
     * @param $userId
     * @param $orderNo
     * @param $status
     * @return mixed
     */
    public static function updateOrderStatusByUserIdAndOrderNo($userId, $orderNo, $status)
    {
        return UserOrder::where(['user_id' => $userId, 'order_no' => $orderNo])
            ->update(['status' => $status]);
    }

    /**
     * 根据用户id和订单号更新订单
     * @param $userId
     * @param $orderNo
     * @param array $data
     * @return mixed
     */
    public static function updateOrderByUserIdAndOrderNo($userId, $orderNo, $data = [])
    {
        return UserOrder::where(['user_id' => $userId, 'order_no' => $orderNo])
            ->update($data);
    }

    /**
     * 获取订单类型ID
     *
     * @param string $nid
     * @return int
     */
    public static function getOrderType($nid = UserVipConstant::ORDER_TYPE)
    {
        $id = UserOrderType::where(['type_nid' => $nid])
            ->value('id');

        return $id ? $id : 1;
    }

    /**
     * 根据订单编号和用户id获取订单
     * @param $orderNo
     * @param $userId
     * @return \Illuminate\Support\Collection
     */
    public static function getOrderDetailByOrderNoAndUserId($orderNo, $userId)
    {
        $userOrder = UserOrder::where([UserOrder::TABLE_NAME . '.order_no' => $orderNo])
            ->where([UserOrder::TABLE_NAME . '.user_id' => $userId])
            ->leftJoin(Platform::TABLE_NAME, UserOrder::TABLE_NAME . '.platform_nid', '=', Platform::TABLE_NAME . '.platform_nid')
            ->get();

        return $userOrder ? $userOrder->toArray() : [];
    }

    /**
     * 根据用户id获取订单列表
     * @param $userId
     * @return mixed
     */
    public static function getOrderByUserId($userId)
    {
        $userOrder = UserOrder::select()
            ->where('user_id', '=', $userId)
            ->get();
        return $userOrder ? $userOrder->toArray() : [];
    }

    /**
     * 根据用户id和订单号获取订单状态
     * @param $userId
     * @param $orderNo
     * @return mixed
     */
    public static function getOrderStatusByUserIdOrderNo($userId, $orderNo)
    {
        $userOrder = UserOrder::select()
            ->where('user_id', '=', $userId)
            ->where('order_no', '=', $orderNo)
            ->first();
        return $userOrder ? $userOrder->toArray() : [];
    }

    /**
     * 根据token获取用户信息
     * @param $accessToken
     * @return array
     */
    public static function getUserAuthByAccessToken($accessToken)
    {
        $userAuth = UserAuth::select()
            ->where('access_token', '=', $accessToken)
            ->first();
        return $userAuth ? $userAuth->toArray() : [];
    }
}
