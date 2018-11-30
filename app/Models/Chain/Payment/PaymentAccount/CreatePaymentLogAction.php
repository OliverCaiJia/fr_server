<?php

namespace App\Models\Chain\Payment\PaymentAccount;

use App\Models\Chain\AbstractHandler;
use App\Models\Factory\Api\UserOrderFactory;

class CreatePaymentLogAction extends AbstractHandler
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
            return $result;
        }
        return false;
    }
}
