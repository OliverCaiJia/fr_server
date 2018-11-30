<?php

namespace App\Models\Chain\Order\PayOrder\UserOrder;

use App\Constants\OrderConstant;
use App\Models\Chain\AbstractHandler;
use App\Models\Factory\Api\UserOrderFactory;

class CheckOrderExistsAction extends AbstractHandler
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

        if (!empty($userOrder) && $userOrder['status'] == 0) {//处理中
//            return $userOrder;
            $this->error['error'] = "用户您好，您还有未支付订单，请先进行支付！";
            return false;
        }
        return true;
    }
}
