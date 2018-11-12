<?php

namespace App\Models\Chain\Order\Assign;

use App\Models\Chain\AbstractHandler;
use App\Models\Factory\Admin\Order\OrderFactory;

class UpdateOrderPersonAction extends AbstractHandler
{
    private $params = [];
    protected $error = ['error' => '更新订单处理人失败，分配失败！', 'code' => 8020];

    public function __construct($params)
    {
        $this->params = $params;
    }

    /**
     * 第二步:更新订单处理人
     *
     * @return array
     */
    public function handleRequest()
    {
        if ($this->updateOrder($this->params)) {
            $this->setSuccessor(new TriggerEventAction($this->params));
            return $this->getSuccessor()->handleRequest();
        } else {
            return $this->error;
        }
    }

    private function updateOrder($params)
    {
        return OrderFactory::updateSaasAuthPersonIdById($params['saas_order_id'], $params['person_id']);
    }
}
