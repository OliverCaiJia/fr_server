<?php

namespace App\Models\Factory\Api;

use App\Constants\UserVipConstant;
use App\Models\Orm\Platform;
use App\Models\Orm\UserAmountEst;
use App\Models\Orm\UserAntifraud;
use App\Models\Orm\UserApply;
use App\Models\Orm\UserApplyLog;
use App\Models\Orm\UserBlacklist;
use App\Models\Orm\UserLoanLog;
use App\Models\Orm\UserLoanTask;
use App\Models\Orm\UserMultiinfo;
use App\Models\Orm\UserOrder;
use App\Models\Orm\UserOrderPlatform;
use App\Models\Orm\UserOrderReport;
use App\Models\Orm\UserOrderType;
use App\Models\Orm\UserPersonal;
use App\Models\Orm\UserPostloan;
use App\Models\Orm\UserReport;
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
        $userOrderObj->p_order_id = $params['p_order_id'];
        $userOrderObj->order_expired = $params['order_expired'];//读配置
        $userOrderObj->amount = $params['amount'];
        $userOrderObj->term = $params['term'];
        $userOrderObj->count = $params['count'];
        $userOrderObj->status = $params['status'];
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
     * 创建反欺诈
     * @param $params
     * @return array|bool
     */
    public static function createAntifraud($params)
    {
        $userAntifraud = new UserAntifraud();
        $userAntifraud->user_id = $params['user_id'];
        $userAntifraud->user_report_id = $params['user_report_id'];
        $userAntifraud->courtcase_cnt = $params['courtcase_cnt'];
        $userAntifraud->dishonest_cnt = $params['dishonest_cnt'];
        $userAntifraud->fraudulence_is_hit = $params['fraudulence_is_hit'];
        $userAntifraud->untrusted_info = $params['untrusted_info'];
        $userAntifraud->suspicious_idcard = $params['suspicious_idcard'];
        $userAntifraud->suspicious_mobile = $params['suspicious_mobile'];
        $userAntifraud->data = $params['data'];
        $userAntifraud->fee = $params['fee'];
        $userAntifraud->create_at = $params['create_at'];
        $userAntifraud->update_at = $params['update_at'];

        if ($userAntifraud->save()) {
            return $userAntifraud->toArray();
        }

        return false;
    }

    /**
     * 创建报告日志
     * @param $params
     * @return array|bool
     */
    public static function createReportLog($params)
    {
        $userReportLog = new UserReportLog();
        $userReportLog->user_id = $params['user_id'];
        $userReportLog->user_report_type_id = $params['user_report_type_id'];
        $userReportLog->order_id = $params['order_id'];


        $userReportLog->status = $params['status'];
        $userReportLog->data = $params['data'];
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
     * 创建报告
     * @param $params
     * @return array|bool
     */
    public static function createReport($params)
    {
        $userReport = new UserReport();
        $userReport->user_id = $params['user_id'];
        $userReport->report_code = $params['report_code'];
        $userReport->report_data = $params['report_data'];
        $userReport->create_at = $params['create_at'];
        $userReport->update_at = $params['update_at'];

        if ($userReport->save()) {
            return $userReport->toArray();
        }
        return false;
    }

    /**
     * 创建申请
     * @param $params
     * @return array|bool
     */
    public static function createApply($params)
    {
        $userApply = new UserApply();
        $userApply->user_id = $params['user_id'];
        $userApply->user_report_id = $params['user_report_id'];
        $userApply->transid = $params['transid'];
        $userApply->data = $params['data'];
        $userApply->fee = $params['fee'];
        $userApply->create_at = $params['create_at'];
        $userApply->update_at = $params['update_at'];

        if ($userApply->save()) {
            return $userApply->toArray();
        }

        return false;
    }

    /**
     * 创建用户电商额度数据
     * @param $params
     * @return array|bool
     */
    public static function createAmountEst($params)
    {
        $userAmountEst = new UserAmountEst();
        $userAmountEst->user_id = $params['user_id'];
        $userAmountEst->user_report_id = $params['user_report_id'];
        $userAmountEst->zm_score = $params['zm_score'];
        $userAmountEst->huabai_limit = $params['huabai_limit'];
        $userAmountEst->credit_amt = $params['credit_amt'];
        $userAmountEst->data = $params['data'];
        $userAmountEst->fee = $params['fee'];
        $userAmountEst->create_at = $params['create_at'];
        $userAmountEst->update_at = $params['update_at'];

        if ($userAmountEst->save()) {
            return $userAmountEst->toArray();
        }

        return false;
    }

    /**
     * 创建贷后行为
     * @param $params
     * @return array|bool
     */
    public static function createPostloan($params)
    {
        $userPostloan = new UserPostloan();
        $userPostloan->user_id = $params['user_id'];
        $userPostloan->user_report_id = $params['user_report_id'];
        $userPostloan->transid = $params['transid'];
        $userPostloan->due_days_non_cdq_12_mon = $params['due_days_non_cdq_12_mon'];
        $userPostloan->pay_cnt_12_mon = $params['pay_cnt_12_mon'];
        $userPostloan->data = $params['data'];
        $userPostloan->fee = $params['fee'];
        $userPostloan->create_at = $params['create_at'];
        $userPostloan->update_at = $params['update_at'];

        if ($userPostloan->save()) {
            return $userPostloan->toArray();
        }

        return false;
    }

    /**
     * 创建黑名单
     * @param $params
     * @return array|bool
     */
    public static function createBlackList($params)
    {
        $userBlacklist = new UserBlacklist();
        $userBlacklist->user_id = $params['user_id'];
        $userBlacklist->user_report_id = $params['user_report_id'];
        $userBlacklist->transid = $params['transid'];
        $userBlacklist->mobile_name_in_blacklist = $params['mobile_name_in_blacklist'];
        $userBlacklist->idcard_name_in_blacklist = $params['idcard_name_in_blacklist'];
        $userBlacklist->black_info_detail = $params['black_info_detail'];
        $userBlacklist->gray_info_detail = $params['gray_info_detail'];
        $userBlacklist->data = $params['data'];
        $userBlacklist->fee = $params['fee'];
        $userBlacklist->create_at = $params['create_at'];
        $userBlacklist->update_at = $params['update_at'];
        if ($userBlacklist->save()) {
            return $userBlacklist->toArray();
        }
        return false;
    }

    /**
     * 创建多头
     * @param $params
     * @return array|bool
     */
    public static function createMultiinfo($params)
    {
        $userMultiinfo = new UserMultiinfo();
        $userMultiinfo->user_id = $params['user_id'];
        $userMultiinfo->user_report_id = $params['user_report_id'];
        $userMultiinfo->register_org_count = $params['register_org_count'];
        $userMultiinfo->loan_cnt = $params['loan_cnt'];
        $userMultiinfo->loan_org_cnt = $params['loan_org_cnt'];
        $userMultiinfo->transid = $params['transid'];
        $userMultiinfo->data = $params['data'];
        $userMultiinfo->fee = $params['fee'];
        $userMultiinfo->create_at = $params['create_at'];
        $userMultiinfo->update_at = $params['update_at'];
        if ($userMultiinfo->save()) {
            return $userMultiinfo->toArray();
        }
        return false;
    }

    /**
     * 创建个人信息
     * @param $params
     * @return array|bool
     */
    public static function createPersonal($params)
    {
        $userPersonal = new UserPersonal();
        $userPersonal->user_id = $params['user_id'];
        $userPersonal->idcard = $params['idcard'];
        $userPersonal->idcard_location = $params['idcard_location'];
        $userPersonal->mobile = $params['mobile'];
        $userPersonal->carrier = $params['carrier'];
        $userPersonal->mobile_location = $params['mobile_location'];
        $userPersonal->name = $params['name'];
        $userPersonal->age = $params['age'];
        $userPersonal->gender = $params['gender'];
        $userPersonal->email = $params['email'];
        $userPersonal->education = $params['education'];
        $userPersonal->is_graduation = $params['is_graduation'];
        $userPersonal->create_at = $params['create_at'];
        $userPersonal->create_ip = $params['create_ip'];
        $userPersonal->update_at = $params['update_at'];
        $userPersonal->update_ip = $params['update_ip'];

        if ($userPersonal->save()) {
            return $userPersonal->toArray();
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
     * 根据id更新订单
     * @param $id
     * @param array $data
     * @return mixed
     */
    public static function updateOrderById($id, $data = [])
    {
        return UserOrder::where(['id' => $id])
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
//            ->leftJoin(Platform::TABLE_NAME, UserOrder::TABLE_NAME . '.platform_nid', '=', Platform::TABLE_NAME . '.platform_nid')
            ->get();

        return $userOrder ? $userOrder->toArray() : [];
    }

    /**
     * 根据订单编号和用户id获取订单详情
     * @param $orderNo
     * @param $userId
     * @return array
     */
    public static function getOrderDetailWithPlatformByOrderNoAndUserId($orderNo, $userId)
    {
        $userOrder = UserOrder::where([UserOrder::TABLE_NAME . '.order_no' => $orderNo])
            ->where([UserOrder::TABLE_NAME . '.user_id' => $userId])
            ->leftJoin(Platform::TABLE_NAME, UserOrder::TABLE_NAME . '.platform_nid', '=', Platform::TABLE_NAME . '.platform_nid')
            ->get();

        return $userOrder ? $userOrder->toArray() : [];
    }

    /**
     * 根据订单编号获取订单详情
     * @param $orderNo
     * @return array
     */
    public static function getOrderDetailByOrderNo($orderNo)
    {
        $userOrder = UserOrder::where([UserOrder::TABLE_NAME . '.order_no' => $orderNo])
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
     * 根据用户id获取订单列表(包含logo）
     * @param $userId
     * @return array
     */
    public static function getOrderAndTypeLogoByUserId($userId)
    {
        $userOrder = UserOrder::where([UserOrder::TABLE_NAME . '.user_id' => $userId])
            ->leftJoin(UserOrderType::TABLE_NAME, UserOrder::TABLE_NAME . '.order_type', '=', UserOrderType::TABLE_NAME . '.id')
            ->get();
        return $userOrder ? $userOrder->toArray() : [];
    }

    /**
     * 根据用户id和订单号获取订单
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
     * 根据用户id和订单号获取订单详情（含平台信息）
     * @param $userId
     * @param $orderNo
     * @return array
     */
    public static function getOrderPlatformByUserIdAndOrderNo($userId, $orderNo)
    {
        $userOrder = UserOrder::where([UserOrder::TABLE_NAME . '.user_id' => $userId])
            ->where([UserOrder::TABLE_NAME . '.order_no' => $orderNo])
            ->leftJoin(UserOrderPlatform::TABLE_NAME, UserOrder::TABLE_NAME . '.id', '=', UserOrderPlatform::TABLE_NAME . '.order_id')
            ->get();
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
     * 根据订单id获取订单类型
     * @param $id
     * @return array
     */
    public static function getOrderTypeById($id)
    {
        $userOrder = UserOrderType::select()
            ->where('id', '=', $id)
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
     * 通过用户id获取用户订单
     * @param $userId
     * @param array $status
     * @return array
     */
    public static function getUserOrderByUserId($userId, $pageSize = 10, $pageIndex)
    {
        $userOrder = UserOrder::select()
            ->where('user_id', '=', $userId)
            ->paginate($pageSize, ['*'], 'page', $pageIndex);
        return $userOrder ? $userOrder->toArray() : [];
    }

    /**
     *
     * @param $userId
     * @param array $status
     * @return array
     */
    public static function getUserOrderByUserIdOrderNoAndStatus($userId, $orderNo, $status = [])
    {
        $userOrder = UserOrder::select()
            ->where('user_id', '=', $userId)
            ->where('order_no', '=', $orderNo)
            ->whereIn('status', $status)
            ->first();
        return $userOrder ? $userOrder->toArray() : [];
    }

    /**
     * 根据用户id和订单id检查订单是否支付
     * @param $userId
     * @param $orderId
     * @return array
     */
    public static function getUserOrderByUserIdAndOrderId($userId, $orderId)
    {
        $userOrder = UserOrder::select()
            ->where('id', '=', $orderId)
            ->where('user_id', '=', $userId)
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

    /**
     * 依据订单号获取订单状态
     * @param $order_no
     */
    public static function getOrderStatusByOrderno($order_no)
    {
        return UserOrder::where(['order_no' => $order_no])->value('status');
    }

    /**
     * 依据用户id和推送产品标识符获取订单推送状态
     * @param $userId
     * @param $spreadNid
     * @return array
     */
    public static function getLoanTaskByUserIdAndSpreadNid($userId, $spreadNid)
    {
        $userLoanTask = UserLoanTask::select()
            ->where('user_id', '=', $userId)
            ->where('spread_nid', '=', $spreadNid)
            ->first();
        return $userLoanTask ? $userLoanTask->toArray() : [];
    }
}
