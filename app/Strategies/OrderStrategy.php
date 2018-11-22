<?php
namespace App\Strategies;

use App\Helpers\RestUtils;
use App\Helpers\Utils;
use App\Models\Chain\Order\Loan\DoReportOrderLogicHandler;
use App\Models\Chain\Order\NoPayOrder\ApplyOrder\ApplyOrderHandler;
use App\Models\Chain\Order\NoPayOrder\ApplyOrder\DoApplyOrderHandler;
use App\Models\Chain\Order\NoPayOrder\ProductOrder\DoProductOrderHandler;
use App\Models\Chain\Order\PayOrder\PaidOrder\DoPaidOrderHandler;
use App\Models\Chain\Order\PayOrder\UserOrder\DoPayOrderHandler;
use App\Models\Chain\Report\Scopion\DoReportOrderHandler;
use App\Models\Factory\Api\UserOrderFactory;
use Illuminate\Http\Request;

class OrderStrategy extends AppStrategy
{
    /**
     * 用户订单入库
     * @param $order
     * @return array
     */
    public static function getDiffOrderTypeChainCreate($order)
    {
        switch ($order['order_type_nid']) {
            //付费报告（一个接口）user_report_log
            case 'order_report':
                $chain = new DoPayOrderHandler($order);
                $result = $chain->handleRequest();
                break;
            //增值服务订单(推荐）（一个接口）user_extra_service_log
            case 'order_extra_service':
                $chain = new DoPayOrderHandler($order);
                $result = $chain->handleRequest();
                break;
            //申请产品订单（一个接口）user_apply_log
            case 'order_product':
                $chain = new DoProductOrderHandler($order);
                $result = $chain->handleRequest();
                break;
            //贷款(两个接口）user_loan_log
            case 'order_apply':
                $chain = new DoApplyOrderHandler($order);
                $result = $chain->handleRequest();
                break;
            default:
                $result = ['error' => RestUtils::getErrorMessage(1139), 'code' => 1139];
        }
        return $result;
    }

    /**
     * 根据不同类型更新
     * @param $order
     * @return array
     */
    public static function getDiffOrderTypeChainForUpdate($order)
    {
        switch ($order['order_type_nid']) {
            //付费
            case 'order_report':
                $chain = new DoPaidOrderHandler($order);
                $result = $chain->handleRequest();
                break;
            //增值服务订单(推荐） //待定
            case 'order_extra_service':
//                $chain = new DoReportOrderLogicHandler($order);
//                $result = $chain->handleRequest();
                break;

            //申请产品订单 无更新
            case 'order_product':
//                $chain = new DoReportOrderLogicHandler($order);
//                $result = $chain->handleRequest();
                break;
            //贷款  //TODO::此更新再确认逻辑
            case 'order_apply':
//                $chain = new DoReportOrderLogicHandler($order);
//                $result = $chain->handleRequest();
                break;
            default:
                $result = ['error' => RestUtils::getErrorMessage(1139), 'code' => 1139];
        }
        return $result;
    }

    /**
     * 根据不同类型查询订单详情
     * @param $order
     * @return array
     */
//    public static function getDiffOrderTypeInfo($userId, $orderNo, $typeNid)
//    {
//        switch ($typeNid) {
//            //付费报告（一个接口）user_report_log
//            case 'order_report':
////                $userId = $this->getUserId($order);
////                $orderNo = $request->input('order_no');
//                $result = UserOrderFactory::getOrderDetailByOrderNoAndUserId($orderNo, $userId);
//                break;
//            //增值服务订单(推荐）（一个接口）user_extra_service_log
//            case 'order_extra_service':
//
//                break;
//
//            //申请产品订单（一个接口）user_apply_log
//            case 'order_product':
//
//                break;
//            //贷款(两个接口）user_loan_log
//            case 'order_apply':
//                $result = UserOrderFactory::getOrderDetailWithPlatformByOrderNoAndUserId($orderNo, $userId);
//                dd($result);
////                $res = [];
////                foreach ($result as $uOrder) {
////                    $res[] = [
////                        "platform_name" => $uOrder['amount'],
////                        "amount" => $uOrder['amount'],
////                        "status" => $uOrder['status']
////                    ];
////                }
//                break;
//            default:
//                $result = ['error' => RestUtils::getErrorMessage(1139), 'code' => 1139];
//        }
//        return $result;
//    }



    /**
     * 日志记录入库
     * @param $order
     * @return array
     */
//    public static function getDiffOrderTypeLog($order)
//    {
//        switch ($order['order_type_nid']) {
//            //付费报告
//            case 'order_report':
//                break;
//            //增值服务订单(推荐）
//            case 'order_extra_service':
////                return UserOrderFactory::createUserApplyLog($order);
//                break;
//
//            //申请产品订单
//            case 'order_product':
//
//                break;
//            //贷款(两个接口）user_loan_log
//            case 'order_apply':
//                $result = [];
//                break;
//            default:
//                $result = ['error' => RestUtils::getErrorMessage(1139), 'code' => 1139];
//        }
//        return $result;
//    }

    public static function reportBak($res)
    {
        $chain = new DoReportOrderHandler($res);
        $result = $chain->handleRequest();
    }
}
