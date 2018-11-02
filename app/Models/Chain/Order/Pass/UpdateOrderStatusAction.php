<?php

namespace App\Models\Chain\Order\Pass;

use App\Constants\OrderConstant;
use App\Models\Chain\AbstractHandler;
use App\Models\Factory\Admin\Order\SaasOrderFactory;

class UpdateOrderStatusAction extends AbstractHandler
{
    private $params = [];
    protected $error = ['error' => '更新订单状态失败，分配失败！', 'code' => 8120];

    public function __construct($params)
    {
        $this->params = $params;
    }

    /**
     * 第二步:更新订单状态
     *
     * @return array
     */
    public function handleRequest()
    {
        if ($this->updateStatus($this->params)) {
            $this->setSuccessor(new TriggerEventAction($this->params));
            return $this->getSuccessor()->handleRequest();
        } else {
            return $this->error;
        }
    }

    private function updateStatus($params)
    {
        return SaasOrderFactory::updateStatus($params['saas_order_id'], OrderConstant::ORDER_STATUS_PASSED);
    }
}
