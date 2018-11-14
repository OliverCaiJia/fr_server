<?php

namespace App\Models\Chain\Order\Assign;

use App\Constants\OrderConstant;
use App\Models\Chain\AbstractHandler;
use App\Models\Factory\Admin\Order\SaasOrderFactory;

class CheckOrderStatusAction extends AbstractHandler
{
    private $params = [];
    protected $error = ['error' => '分配订单不合法，分配失败！', 'code' => 8010];

    public function __construct($params)
    {
        $this->params = $params;
    }

    /**
     * 第一步:检查订单状态是否合法
     *
     * @return array
     */
    public function handleRequest()
    {
        if ($this->checkStatus($this->params)) {
            $this->setSuccessor(new UpdateOrderPersonAction($this->params));
            return $this->getSuccessor()->handleRequest();
        } else {
            return $this->error;
        }
    }

    private function checkStatus($params)
    {
        $saasOrderId = $params['saas_order_id'];

        $status = SaasOrderFactory::getOrderStatusById($saasOrderId);
        if ($status != OrderConstant::ORDER_STATUS_PENDING) {
            $this->error['error'] = "saas订单ID:{$saasOrderId}，此订单不是待处理状态，不能分配！";
            return false;
        }
        return true;
    }
}
