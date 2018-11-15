<?php

namespace App\Models\Chain\Order\Loan;

use App\Models\Chain\AbstractHandler;
use App\Models\Factory\Api\UserOrderFactory;

class CreateUserOrderrAction extends AbstractHandler
{
    private $params = [];
    protected $error = ['error' => '创建订单失败！', 'code' => 8220];

    public function __construct($params)
    {
        $this->params = $params;
    }

    public function handleRequest()
    {
        $result = UserOrderFactory::createOrder($this->params);
        if ($result) {
            return true;
        }
        return $this->error;
    }
}
