<?php

namespace App\Models\Chain\Order\PayOrder\UserExtraOrder;

use App\Models\Chain\AbstractHandler;
use App\Models\Factory\Api\UserOrderFactory;

class CreateUserExtraOrderAction extends AbstractHandler
{
    private $params = [];
    protected $error = ['error' => '创建订单失败！', 'code' => 8220];

    public function __construct($params)
    {
        $this->params = $params;
    }

    public function handleRequest()
    {
        if ($this->createUserExtra($this->params)) {
            $this->setSuccessor(new CreateUserFreeProductAction($this->params));
            return $this->getSuccessor()->handleRequest();
        } else {
            return $this->error;
        }
    }

    private function createUserExtra($params)
    {
        $result = UserOrderFactory::createOrder($params);
        if ($result) {
            $this->params['order_id'] = $result['id'];
            $this->params['order_no'] = $result['order_no'];
            $this->params['status'] = $result['status'];
            $this->params['order_expired'] = $result['order_expired'];
            return $result;
        }
        return false;
    }
}
