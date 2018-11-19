<?php

namespace App\Models\Chain\Order\NoPayOrder\ApplyOrder;

use App\Models\Chain\AbstractHandler;
use App\Models\Factory\Api\UserOrderFactory;
use App\Models\Orm\UserOrderType;

class IfHasPaidOrderAction extends AbstractHandler
{
    private $params = [];
    protected $error = ['error' => '您好，订单还未付费！', 'code' => 8010];

    public function __construct($params)
    {
        $this->params = $params;
    }


    public function handleRequest()
    {
        if ($this->checkIfPaid($this->params)) {
            $this->setSuccessor(new CreatePushTaskAction($this->params));
            return $this->getSuccessor()->handleRequest();
        } else {
            return $this->error;
        }
    }

    private function checkIfPaid($params)
    {
        $userId = $params['user_id'];
        $orderTypeNid = $params['order_type_nid'];
        $pid = $params['pid'];
        $orderType = UserOrderFactory::getOrderTypeByTypeNid($orderTypeNid);
        $this->params['order_type'] = $orderType['id'];
        $userOrder = UserOrderFactory::getUserOrderByUserIdAndOrderId($userId, $pid);

        if (!empty($userOrder) && $userOrder['status'] != 1) {//订单处理完成
            $this->error['error'] = "用户您好，您未能通过报告订单，请先进行支付.";
            return false;
        }
        return true;
    }
}
