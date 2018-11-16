<?php

namespace App\Models\Chain\Order\PayOrder\PaidOrder;

use App\Constants\OrderConstant;
use App\Models\Chain\AbstractHandler;
use App\Models\Factory\Api\UserOrderFactory;

class IfOrderPaidAction extends AbstractHandler
{
    private $params = [];
    protected $error = ['error' => '订单状态不合法，审核（拒绝）失败！', 'code' => 8210];

    public function __construct($params)
    {
        $this->params = $params;
    }

    public function handleRequest()
    {
        if ($this->ifOrderPaid($this->params)) {
            $this->setSuccessor(new UpdateUserOrderAction($this->params));
            return $this->getSuccessor()->handleRequest();
        } else {
            return $this->error;
        }
    }

    private function ifOrderPaid($params)
    {
        $userId = $params['user_id'];
        $orderNo = $params['order_no'];
        $userOrder = UserOrderFactory::getUserOrderByUserIdAndOrderNo($userId, $orderNo);
        if (!empty($userOrder) && $userOrder['status'] != 0) {//处理中
            $this->error['error'] = "您好，订单状态必须是支付中！";
            return false;
        }
        return true;
    }
}
