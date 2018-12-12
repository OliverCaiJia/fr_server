<?php

namespace App\Models\Chain\Order\PayOrder\UserOrder;

use App\Helpers\Logger\SLogger;
use App\Models\Chain\AbstractHandler;
use App\Models\Factory\Api\UserOrderFactory;

class CreateUserOrderAction extends AbstractHandler
{
    private $params = [];
    protected $error = ['error' => '创建订单失败！', 'code' => 8220];

    public function __construct($params)
    {
        $this->params = $params;
    }

    public function handleRequest()
    {
        SLogger::getStream()->info(__CLASS__);
        SLogger::getStream()->info(json_encode($this->params));
        SLogger::getStream()->info(__CLASS__);
        $result = UserOrderFactory::createOrder($this->params);

        if ($result) {
            return $result;
        }
        return false;
    }
}
