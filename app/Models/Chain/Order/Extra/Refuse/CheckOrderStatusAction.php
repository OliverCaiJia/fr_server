<?php

namespace App\Models\Chain\Order\Loan\Refuse;

use App\Constants\OrderConstant;
use App\Models\Chain\AbstractHandler;
use App\Models\Factory\Admin\Order\SaasOrderFactory;

class CheckOrderStatusAction extends AbstractHandler
{
    private $params = [];
    protected $error = ['error' => '订单状态不合法，审核（拒绝）失败！', 'code' => 8210];

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
            $this->setSuccessor(new InsertRefuseReasonAction($this->params));
            return $this->getSuccessor()->handleRequest();
        } else {
            return $this->error;
        }
    }

    private function checkStatus($params)
    {
        $saasOrderId = $params['saas_order_id'];

        $status = SaasOrderFactory::getOrderStatusById($saasOrderId);
        if ($status != OrderConstant::ORDER_STATUS_PASSED) {
            $this->error['error'] = "saas订单ID:{$saasOrderId}，此订单不是待放款处理状态，不能拒绝！";
            return false;
        }
        return true;
    }
}
