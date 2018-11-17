<?php

namespace App\Models\Chain\Order\PayOrder\PaidOrder;

use App\Constants\OrderConstant;
use App\Models\Chain\AbstractHandler;
use App\Models\Factory\Api\UserOrderFactory;

class CheckOrderNoExistsAction extends AbstractHandler
{
    private $params = [];
    protected $error = ['error' => '订单状态不合法，审核（拒绝）失败！', 'code' => 8210];

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
        if ($this->checkOrderNoExists($this->params)) {
            $this->setSuccessor(new IfOrderPaidAction($this->params));
            return $this->getSuccessor()->handleRequest();
        } else {
            return $this->error;
        }
    }

    private function checkOrderNoExists($params)
    {
        $orderNo = $params['order_no'];



        if (empty($orderNo)) {
            $this->error['error'] = "您好，订单编号不存在！";
            return false;
        }
        return true;
    }
}
