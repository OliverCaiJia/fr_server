<?php

namespace App\Models\Chain\Order\NoPayOrder\ApplyOrder;

use App\Models\Chain\AbstractHandler;
use App\Models\Chain\Order\PayOrder\UserOrder\CheckAmountCountAction;
use App\Models\Factory\Api\UserOrderFactory;

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
            $this->setSuccessor(new CheckAmountCountAction($this->params));
            return $this->getSuccessor()->handleRequest();
        } else {
            return $this->error;
        }
    }

    private function checkIfPaid($params)
    {
        $userId = $params['user_id'];
        $orderType = $params['order_type'];
        $userOrder = UserOrderFactory::getUserOrderByUserIdAndOrderType($userId, $orderType);
        if (!empty($userOrder) && $userOrder['status'] != 1) {//订单处理完成
            $this->error['error'] = "用户您好，您未能通过报告订单，请先进行支付.";
            return false;
        }
        return true;
    }
}
