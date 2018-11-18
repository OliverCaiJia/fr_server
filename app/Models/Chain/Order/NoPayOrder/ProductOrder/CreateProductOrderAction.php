<?php

namespace App\Models\Chain\Order\NoPayOrder\ProductOrder;

use App\Models\Chain\AbstractHandler;
use App\Models\Factory\Admin\Order\OrderFactory;
use App\Models\Factory\Api\UserOrderFactory;

class CreateProductOrderAction extends AbstractHandler
{
    private $params = [];
    protected $error = ['error' => '记录拒绝理由失败，审核（拒绝）失败！', 'code' => 8220];

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
