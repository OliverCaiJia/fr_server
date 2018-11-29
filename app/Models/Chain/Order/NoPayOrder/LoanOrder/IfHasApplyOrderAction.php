<?php

namespace App\Models\Chain\Order\NoPayOrder\LoanOrder;

use App\Constants\UserOrderConstant;
use App\Models\Chain\AbstractHandler;
use App\Models\Factory\Api\UserOrderFactory;
use App\Models\Orm\UserOrderType;

class IfHasApplyOrderAction extends AbstractHandler
{
    private $params = [];
    protected $error = ['error' => '您好，订单还未付费！', 'code' => 8010];

    public function __construct($params)
    {
        $this->params = $params;
    }


    public function handleRequest()
    {
        if ($this->ifHasApplyOrder($this->params)) {
            $this->setSuccessor(new CreatePushTaskAction($this->params));
            return $this->getSuccessor()->handleRequest();
        } else {
            return $this->error;
        }
    }

    private function ifHasApplyOrder($params)
    {
        $orderTypeNid = UserOrderConstant::ORDER_APPLY;
        $orderType = UserOrderFactory::getOrderTypeByTypeNid($orderTypeNid);
        $userOrderApply = UserOrderFactory::getUserOrderByUserIdAndOrderType($params['user_id'], $orderType['id']);
        if (empty($userOrderApply)) {
            $this->error['error'] = "用户您好，您还没有贷款订单.";
            return false;
        }
        return true;
    }
}
