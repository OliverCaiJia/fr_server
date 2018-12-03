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
        $result = UserOrderFactory::createOrder($this->params);
        SLogger::getStream()->error('=========33===========');
        SLogger::getStream()->error(json_encode($result));
        SLogger::getStream()->error('---------44-----------');

        if ($result) {
            return $result;
        }
        return false;
    }
}
