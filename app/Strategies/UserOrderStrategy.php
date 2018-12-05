<?php

namespace App\Strategies;

use App\Helpers\Logger\SLogger;
use App\Helpers\Utils;
use App\Models\Chain\Order\DoAssignHandler;
use App\Models\Chain\Order\NoPayOrder\LoanOrder\DoApplyOrderHandler;
use App\Models\Chain\Order\PayOrder\PaidOrder\DoPaidOrderHandler;
use App\Models\Chain\Payment\PaymentAccount\DoPaymentAccountHandler;
use App\Models\Chain\Report\Scopion\DoReportOrderHandler;
use App\Models\Factory\Api\UserAuthFactory;
use App\Models\Factory\Api\UserinfoFactory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class UserOrderStrategy extends AppStrategy
{
    /**
     * 创建订单号
     *
     * @param string $type
     *
     * @return string
     */
    public static function createOrderNo($extra = "A", $type = 'SGD')
    {
        $NO = date('Y') . date('m') . date('d') . date('H') . date('i') . date('s') . '-' . Utils::randomNumber();

        return $type . '-' . $extra . '-' . $NO;
    }

    /**
     * 根据订单类型唯一标识获取标识简称
     * @param $orderTypeNid
     * @return string
     */
    public static function getExtra($orderTypeNid)
    {
        $nidArr = explode('_', $orderTypeNid);
        $extra = strtoupper($nidArr[1][0]);
        return $extra;
    }

    /**
     * 获取渠道名称展示文案
     *
     * @param $order
     *
     * @return mixed
     */
    public static function getChannelText($order)
    {
        if (is_array($order)) {
            $channel = $order['saas_channel_detail'];
            return $channel['name'];
        }

        $channel = $order->saas_channel_detail;

        return $channel['name'];
    }

    /**
     * 获取状态展示文案
     *
     * @param $status
     *
     * @return string
     */
    public static function getStatusText($status)
    {
        switch ($status) {
            case 1:
                $status = '待初审订单';
                break;
            case 2:
                $status = '待放款订单';
                break;
            case 3:
                $status = '审核不通过';
                break;
            case 4:
                $status = '已拒绝放款';
                break;
            case 5:
                $status = '待还款订单';
                break;
            case 6:
                $status = '逾期未还订单';
                break;
            case 7:
                $status = '已还款订单';
                break;
        }

        return $status;
    }

    public static function getUserIdByXToken(Request $request)
    {
        $token = $request->input('token') ?: $request->header('X-Token');
        $userOrder = UserAuthFactory::getUserAuthByAccessToken($token);
        return $userOrder['id'];
    }

    /**
     * 根据不同订单类型进行支付回调
     * @param $typeNid
     * @param $data
     * @param $resData
     * @param $userId
     * @return string
     * @throws \Exception
     */
    public static function getChainsByTypeNid($typeNid, $data, $resData, $userId)
    {
        switch ($typeNid) {
            case 'order_report':
                //事务处理
                DB::beginTransaction();
                try {
                    //修改订单状态
                    $orderTypeChain = new DoPaidOrderHandler($data);
                    $typeRes = $orderTypeChain->handleRequest();
                    if (isset($typeRes['error'])) {
                        return 'ERROR';
                    }

                    //生成信用报告
                    $data['report_type_nid'] = $typeRes['report_type_nid'];
                    $reportChain = new DoReportOrderHandler($data);
                    $reportRes = $reportChain->handleRequest();
                    if (isset($reportRes['error'])) {
                        return 'ERROR';
                    }

                    //推送一键贷
                    $task = new DoApplyOrderHandler($data);
                    $taskRes = $task->handleRequest();
                    if (isset($taskRes['error'])) {
                        return 'ERROR';
                    }
                } catch (\Exception $e) {
                    //订单异常事务回滚
                    DB::rollBack();
                    Log::error($e);
                    //异常日志记录
                    SLogger::getStream()->error('支付回调, 支付回调订单-catch');
                    SLogger::getStream()->error($e->getMessage());
                    return 'ERROR';
                }
                //事务提交
                DB::commit();

                //记录
                $paymentChain = new DoPaymentAccountHandler($resData);
                $paymentChain->handleRequest();

                return 'SUCCESS';
                break;

            case 'order_extra_service':
                //事务处理
                DB::beginTransaction();
                try {
                    //修改订单状态
                    $orderTypeChain = new DoPaidOrderHandler($data);
                    $typeRes = $orderTypeChain->handleRequest();
                    if (isset($typeRes['error'])) {
                        return 'ERROR';
                    }

                    //更新
                    $userInfo['service_status'] = 5;//增值服务状态
                    $userInfo['update_at'] = date('Y-m-d H:i:s');
                    $extraOrder = UserInfoFactory::UpdateUserInfoStatus($userId, $userInfo);
                    if (!$extraOrder) {
                        return 'ERROR';
                    }
                } catch (\Exception $e) {
                    //订单异常事务回滚
                    DB::rollBack();
                    Log::error($e);
                    //异常日志记录
                    SLogger::getStream()->error('支付回调, 支付回调订单-catch');
                    SLogger::getStream()->error($e->getMessage());
                    return 'ERROR';
                }
                //事务提交
                DB::commit();
                //记录
                $paymentChain = new DoPaymentAccountHandler($resData);
                $paymentChain->handleRequest();

                return 'SUCCESS';
                break;
        }
    }
}
