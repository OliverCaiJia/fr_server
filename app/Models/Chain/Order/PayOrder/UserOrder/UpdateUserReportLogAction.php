<?php

namespace App\Models\Chain\Order\PayOrder\UserOrder;

use App\Models\Chain\AbstractHandler;
use App\Models\Factory\Api\UserOrderFactory;

class UpdateUserReportLogAction extends AbstractHandler
{
    private $params = [];
    protected $error = ['error' => '创建订单失败！', 'code' => 8220];

    public function __construct($params, $data)
    {
        $this->params = $params;
        $this->data = $data;
    }

    public function handleRequest()
    {
        $result = UserOrderFactory::updateUserReportLogOrderIdById($this->params);

        if ($result) {
            return $this->data;
        }
        return false;
    }
}
