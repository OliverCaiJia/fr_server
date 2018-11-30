<?php

namespace App\Models\Chain\Order\PayOrder\PaidOrder;

use App\Constants\OrderConstant;
use App\Helpers\Logger\SLogger;
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
        $orderNo = $params['order_no'];
        $userOrder = UserOrderFactory::getUserOrderByOrderNo($orderNo);
        SLogger::getStream()->error('==================================='.json_encode($orderNo).'===========================================');
        if (empty($userOrder)) {//处理中
            $this->error['error'] = "您好，订单不存在！";
            return false;
        }
        if ($userOrder['status'] != 0) {//处理中
            $this->error['error'] = "您好，订单状态必须是支付中！";
            return false;
        }
        $status = 1;//订单处理完成
        $userOrderTypeNid = UserOrderFactory::getOrderTypeNidByTypeIdAndStatus($userOrder['order_type'], $status);
        $this->params['order_type_nid'] = $userOrderTypeNid['type_nid'];
        $this->params['user_id'] = $userOrder['user_id'];
        $this->params['order_no'] = $userOrder['order_no'];
        $this->params['p_order_id'] = $userOrder['p_order_id'];
        $this->params['order_expired'] = $userOrder['order_expired'];
        $this->params['amount'] = $userOrder['amount'];
        $this->params['term'] = $userOrder['term'];
        $this->params['count'] = $userOrder['count'];
        $this->params['status'] = $userOrder['status'];
        $this->params['create_at'] = $userOrder['create_at'];
        return true;
    }
}
