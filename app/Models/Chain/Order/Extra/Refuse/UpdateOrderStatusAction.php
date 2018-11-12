<?php

namespace App\Models\Chain\Order\Loan\Refuse;

use App\Constants\OrderConstant;
use App\Models\Chain\AbstractHandler;
use App\Models\Factory\Admin\Order\SaasOrderFactory;

class UpdateOrderStatusAction extends AbstractHandler
{
    private $params = [];
    protected $error = ['error' => '更新订单状态失败，审核（拒绝）失败！', 'code' => 8230];

    public function __construct($params)
    {
        $this->params = $params;
    }

    /**
     * 第三步:更新订单状态
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

    /**
     *
     * @param $params
     *
     * @return bool
     */
    private function updateStatus($params)
    {
        return SaasOrderFactory::updateStatus($params['saas_order_id'], OrderConstant::ORDER_STATUS_LOAN_REFUSED);
    }
}
