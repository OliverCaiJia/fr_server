<?php

namespace App\Models\Chain\Order\Refuse;

use App\Models\Chain\AbstractHandler;
use App\Models\Factory\Admin\Order\OrderFactory;

class InsertRefuseReasonAction extends AbstractHandler
{
    private $params = [];
    protected $error = ['error' => '记录拒绝理由失败，审核（拒绝）失败！', 'code' => 8220];

    public function __construct($params)
    {
        $this->params = $params;
    }

    /**
     * 第二步:记录拒绝理由
     *
     * @return array
     */
    public function handleRequest()
    {
        if ($this->insertReason($this->params)) {
            $this->setSuccessor(new UpdateOrderStatusAction($this->params));
            return $this->getSuccessor()->handleRequest();
        } else {
            return $this->error;
        }
    }

    private function insertReason($params)
    {
        return OrderFactory::insertRefuseReason($params['saas_order_id'], $params['reason']);
    }
}
