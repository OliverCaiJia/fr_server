<?php
namespace App\Strategies;

use App\Helpers\RestUtils;
use App\Helpers\Utils;
use App\Models\Chain\Order\Loan\DoReportOrderLogicHandler;
use App\Models\Chain\Order\NoPayOrder\LoanOrder\DoApplyOrderHandler;
use App\Models\Chain\Order\NoPayOrder\ProductOrder\DoProductOrderHandler;
use App\Models\Chain\Order\PayOrder\PaidOrder\DoPaidOrderHandler;
use App\Models\Chain\Order\PayOrder\UserExtraOrder\DoPayExtraOrderHandler;
use App\Models\Chain\Order\PayOrder\UserOrder\DoPayOrderHandler;
use App\Models\Chain\Report\Scopion\DoReportOrderHandler;
use App\Models\Factory\Api\UserBorrowLogFactory;
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
                $userBorrowLog = UserBorrowLogFactory::getBorrowLogDesc($order['user_id']);
                $order['money'] = $userBorrowLog['loan_amount'];
                $order['term'] = $userBorrowLog['loan_peroid'];
                $chain = new DoPayExtraOrderHandler($order);
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


    public static function reportBak($res)
    {
        $chain = new DoReportOrderHandler($res);
        $result = $chain->handleRequest();
    }
}
