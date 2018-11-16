<?php

namespace App\Models\Chain\Order\PayOrder\UserOrder;

use App\Constants\OrderConstant;
use App\Models\Chain\AbstractHandler;
use App\Models\Factory\Api\UserOrderFactory;

class CheckAmountCountAction extends AbstractHandler
{
    private $params = [];
    protected $error = ['error' => '订单金额必须大于0, 数量必须是1！', 'code' => 8210];

    public function __construct($params)
    {
        $this->params = $params;
    }

    /**
     * 第一步:检查是否有未支付订单
     *
     * @return array
     */
    public function handleRequest()
    {
        if ($this->checkAmount($this->params) && $this->checkCount($this->params)) {
            $this->setSuccessor(new CreateUserOrderAction($this->params));
            return $this->getSuccessor()->handleRequest();
        } else {
            return $this->error;
        }
    }

    private function checkAmount($params)
    {
        $amount = $params['amount'];
        if ($amount < 0) {//处理中
            $this->error['error'] = "您好，订单金额不能小于0！";
            return false;
        }
        return true;
    }

    private function checkCount($params)
    {
        $count = $params['count'];
        if ($count != 1) {//处理中
            $this->error['error'] = "您好，订单数量必须是一！";
            return false;
        }
        return true;
    }
}
