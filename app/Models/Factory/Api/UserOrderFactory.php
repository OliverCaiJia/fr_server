<?php

namespace App\Models\Factory\Api;

use App\Constants\UserVipConstant;
use App\Models\Orm\Platform;
use App\Models\Orm\UserApplyLog;
use App\Models\Orm\UserLoanLog;
use App\Models\Orm\UserOrder;
use App\Models\Orm\UserOrderReport;
use App\Models\Orm\UserOrderType;
use App\Models\Orm\UserReportLog;
use App\Models\Orm\UserReportType;

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
        $userOrderObj->order_type = $params['order_type'];
        $userOrderObj->payment_log_id = $params['payment_log_id'];
        $userOrderObj->order_expired = $params['order_expired'];//读配置
        $userOrderObj->amount = $params['amount'];
        $userOrderObj->term = $params['term'];
        $userOrderObj->count = $params['count'];
        $userOrderObj->status = 0;
        $userOrderObj->create_ip = $params['create_ip'];
        $userOrderObj->create_at = $params['create_at'];
        $userOrderObj->update_ip = $params['update_ip'];
        $userOrderObj->update_at = $params['update_at'];

        if ($userOrderObj->save()) {
            return $userOrderObj->toArray();
        }

        return false;
    }

    /**
     * 根据用户id和订单号更新订单状态
     * @param $userId
     * @param $orderNo
     * @param $status
     * @return mixed
     */
    public static function updateOrderStatusBUserIdAndOrderNo($userId, $orderNo, $status)
    {
        return UserOrder::where(['user_id' => $userId, 'order_no' => $orderNo])
            ->update(['status' => $status]);
    }

    /**
     * 根据用户id和订单号更新订单状态
     * @param $userId
     * @param $orderNo
     * @param $status
     * @return mixed
     */
    public static function updatePersonByUserIdAndOrderNo($userId, $orderNo, $status)
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
    public static function getOrderByUserIdOrderNo($userId, $orderNo)
    {
        $userOrder = UserOrder::select()
            ->where('user_id', '=', $userId)
            ->where('order_no', '=', $orderNo)
            ->first();
        return $userOrder ? $userOrder->toArray() : [];
    }

    /**
     * 根据订单类型唯一标识获取订单类型
     * @param $typeNid
     * @return array
     */
    public static function getOrderTypeByTypeNid($typeNid)
    {
        $userOrder = UserOrderType::select()
            ->where('type_nid', '=', $typeNid)
            ->where('status', '=', 1)//TODO::CONSTANT
            ->first();
        return $userOrder ? $userOrder->toArray() : [];
    }

    /**
     * 根据订单id获取订单唯一标识
     * @param $typeId
     * @return array
     */
    public static function getOrderTypeNidByTypeId($typeId)
    {
        $userOrder = UserOrderType::select()
            ->where('id', '=', $typeId)
            ->where('status', '=', 1)//TODO::CONSTANT
            ->first();
        return $userOrder ? $userOrder->toArray() : [];
    }

    /**
     * 通过用户id和订单类型获取用户订单
     * @param $userId
     * @param $orderType
     * @return array
     */
    public static function getUserOrderByUserIdAndOrderType($userId, $orderType)
    {
        $userOrder = UserOrder::select()
            ->where('user_id', '=', $userId)
            ->where('order_type', '=', $orderType)
            ->first();
        return $userOrder ? $userOrder->toArray() : [];
    }

    /**
     * 通过用户id和订单编号获取用户订单
     * @param $userId
     * @param $orderNo
     * @return array
     */
    public static function getUserOrderByUserIdAndOrderNo($userId, $orderNo)
    {
        $userOrder = UserOrder::select()
            ->where('user_id', '=', $userId)
            ->where('order_no', '=', $orderNo)
            ->first();
        return $userOrder ? $userOrder->toArray() : [];
    }

    /**
     * 通过订单编号获取用户订单
     * @param $orderNo
     * @return array
     */
    public static function getUserOrderByOrderNo($orderNo)
    {
        $userOrder = UserOrder::select()
            ->where('order_no', '=', $orderNo)
            ->first();
        return $userOrder ? $userOrder->toArray() : [];
    }

    /**
     * @param $params
     * @return array|bool
     */
    public static function createUserApplyLog($params)
    {
        $userApplyLog = new UserApplyLog();
        $userApplyLog->user_id = $params['user_id'];
        $userApplyLog->product_id = $params['product_id'];
        $userApplyLog->channel_id = $params['channel_id'];
        $userApplyLog->channel_nid = $params['channel_nid'];
        $userApplyLog->channel_title = $params['channel_title'];
        $userApplyLog->create_at = date('Y-m-d H:i:s', time());
        $userApplyLog->update_at = date('Y-m-d H:i:s', time());

        if ($userApplyLog->save()) {
            return $userApplyLog->toArray();
        }
        return false;
    }

    /**
     * @param $params
     * @return array|bool
     */
    public static function createUserLoanLog($params)
    {
//        `id` int(11) unsigned NOT NULL AUTO_INCREMENT COMMENT 'id',
//  `user_id` int(11) unsigned NOT NULL COMMENT '用户id',
//  `platform_id` int(11) unsigned NOT NULL COMMENT '平台接口id',
//  `loan_order_id` int(11) NOT NULL COMMENT '贷款申请订单id',
//  `expire_day` int(10) NOT NULL DEFAULT '0' COMMENT '失效时间',
//  `loan_amount` decimal(10,2) NOT NULL DEFAULT '0.00' COMMENT '申请金额',
//  `loan_peroid` int(8) NOT NULL DEFAULT '0' COMMENT '申请周期',
//  `request_data` json NOT NULL COMMENT '请求数据参数',
//  `response_data` json NOT NULL COMMENT '响应返回数据',
//  `create_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP COMMENT '创建时间',
//  `update_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP COMMENT '更新时间',
        $userLoanLog = new UserLoanLog();
        $userLoanLog->user_id = $params['user_id'];


        $userLoanLog->product_id = $params['product_id'];
        $userLoanLog->channel_id = $params['channel_id'];
        $userLoanLog->channel_nid = $params['channel_nid'];
        $userLoanLog->channel_title = $params['channel_title'];
        $userLoanLog->create_at = date('Y-m-d H:i:s', time());
        $userLoanLog->update_at = date('Y-m-d H:i:s', time());

        if ($userLoanLog->save()) {
            return $userLoanLog->toArray();
        }
        return false;
    }


    /**
     * 通过报告标识获取报告类型
     * @param $typeNid
     * @return array
     */
    public static function getUserReportTypeByTypeNid($typeNid)
    {
        $userOrder = UserReportType::select()
            ->where('report_type_nid', '=', $typeNid)
            ->where('status', '=', 1)//TODO::CONSTANT
            ->first();
        return $userOrder ? $userOrder->toArray() : [];
    }

//    /**
//     * 创建订单报告中间表
//     * @param $params
//     * @return bool
//     */
//    public static function createOrderReport($params)
//    {
//        dd($params);
//        $userOrderReport = new UserOrderReport();
//        $userOrderReport->order_id = $params['order_id'];
//        $userOrderReport->report_id = $params['report_id'];
//
//        return $userOrderReport->save();
//    }

    /**
     *创建用户报告日志
     * @param $params
     * @return bool
     */
    public static function createUserReportLog($params)
    {
        $userReportLog = new UserReportLog();
        $userReportLog->user_report_type_id = $params['user_report_type_id'];
        $userReportLog->user_id = $params['user_id'];
        $userReportLog->order_id = $params['order_id'];
        $userReportLog->status = $params['status'];
        $userReportLog->create_at = $params['create_at'];
        $userReportLog->create_ip = $params['create_ip'];
        $userReportLog->update_at = $params['update_at'];
        $userReportLog->update_ip = $params['update_ip'];

        if ($userReportLog->save()) {
            return $userReportLog->toArray();
        }
        return false;
    }

    /**
     * 更新订单编号
     * @param $params
     * @return mixed
     */
    public static function UpdateUserReportLogOrderIdById($params)
    {
        return UserReportLog::where(['id' => $params['user_report_log_id']])
            ->update(['order_id' => $params['user_order_id']]);
    }
}
