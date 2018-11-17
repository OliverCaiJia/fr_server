<?php

namespace App\Models\Chain\Order\PayOrder\UserOrder;

use App\Constants\OrderConstant;
use App\Models\Chain\AbstractHandler;
use App\Models\Factory\Api\UserOrderFactory;

class CreateOrderReportAction extends AbstractHandler
{
    private $params = [];
    protected $error = ['error' => '订单状态不合法，审核（拒绝）失败！', 'code' => 8210];

    public function __construct($params)
    {
        $this->params = $params;
    }

    /**
     *
     *
     * @return array
     */
    public function handleRequest()
    {
//        if ($this->createReportLog($this->params)) {
//            $this->setSuccessor(new CheckAmountCountAction($this->params));
//            return $this->getSuccessor()->handleRequest();
//        } else {
//            return $this->error;
//        }

        $result = UserOrderFactory::createOrderReport($this->params);
        if ($result) {
            return true;
        }
        return $this->error;
    }

//    private function createOrderReport($params)
//    {
//        $data['user_report_type_id'] = $params['user_report_type_id'];
//        $data['user_id'] = $params['user_id'];
//        $data['order_id'] = $params['order_id'];
//        $data['status'] = $params['status'];
//        $data['create_at'] = $params['create_at'];
//        $data['create_ip'] = $params['create_ip'];
//        $data['update_at'] = $params['update_at'];
//        $data['update_ip'] = $params['update_ip'];
//
//        $userReportLog = UserOrderFactory::createOrderReport($data);
//
////        $userId = $params['user_id'];
////        $orderType = $params['order_type'];
////        $userOrder = UserOrderFactory::getUserOrderByUserIdAndOrderType($userId, $orderType);
////
//        if (!$userReportLog) {
//            $this->error['error'] = "您好，报告记录关系异常！";
//            return false;
//        }
//        return true;
//    }
}
