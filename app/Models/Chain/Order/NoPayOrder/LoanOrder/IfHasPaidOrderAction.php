<?php

namespace App\Models\Chain\Order\NoPayOrder\LoanOrder;

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
            $this->setSuccessor(new IfHasApplyOrderAction($this->params));
            return $this->getSuccessor()->handleRequest();
        } else {
            return $this->error;
        }
    }

    private function checkIfPaid($params)
    {
        $orderNo = $params['order_no'];
        $userOrder = UserOrderFactory::getUserOrderByOrderNo($orderNo);
        UserOrderFactory::get($orderTypeNid);

        $orderType = UserOrderFactory::get($orderTypeNid);
        $this->params['order_type'] = $orderType['id'];
        $userOrder = UserOrderFactory::getUserOrderByUserIdAndOrderId($userId, $pid);

        if (!empty($userOrder) && $userOrder['status'] != 1) {
            $this->error['error'] = "用户您好，您未能通过报告订单，请先进行支付.";
            return false;
        }
        return true;
    }
}
