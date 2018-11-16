<?php
namespace App\Strategies;

use App\Helpers\RestUtils;
use App\Models\Chain\Order\Loan\DoReportOrderLogicHandler;
use App\Models\Chain\Order\PayOrder\PaidOrder\DoPaidOrderHandler;
use App\Models\Chain\Order\PayOrder\UserOrder\DoPayOrderHandler;

class OrderStrategy extends AppStrategy
{
    public static function getDiffOrderTypeChain($order)
    {
        switch ($order['order_type_nid']) {


            //付费
            case 'order_report':
                $chain = new DoPayOrderHandler($order);
                $result = $chain->handleRequest();
                break;
            //增值服务订单
            case 'order_extra_service':
                $chain = new DoReportOrderLogicHandler($order);
                $result = $chain->handleRequest();
                break;

            //申请产品订单
            case 'order_product':
                $chain = new DoReportOrderLogicHandler($order);
                $result = $chain->handleRequest();
                break;
            //贷款
            case 'order_apply':
                $chain = new DoReportOrderLogicHandler($order);
                $result = $chain->handleRequest();
                break;
                //支付成功回调测试
//            case 'order_report':
//                $chain = new DoPaidOrderHandler($order);
//                $result = $chain->handleRequest();
//                break;
            default:
                $result = ['error' => RestUtils::getErrorMessage(1139), 'code' => 1139];
        }
        return $result;
    }
}
