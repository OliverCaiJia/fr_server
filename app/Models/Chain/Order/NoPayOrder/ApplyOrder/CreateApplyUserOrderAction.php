<?php

namespace App\Models\Chain\Order\Loan;

use App\Helpers\Utils;
use App\Models\Chain\AbstractHandler;
use App\Models\Factory\Api\UserOrderFactory;
use App\Strategies\UserOrderStrategy;

class CreateApplyUserOrderAction extends AbstractHandler
{
    private $params = [];
    protected $error = ['error' => '创建订单失败！', 'code' => 8220];

    public function __construct($params)
    {
        $this->params = $params;
        $this->data = $params;
    }

    public function handleRequest()
    {
        $data = [];
        $data =$this->params;
        
        $data['user_id'] = $this->params['user_id'];
        $data['order_no'] = UserOrderStrategy::createOrderNo();
        $data['order_type'] = $this->params['order_type'];
        $data['p_order_id'] = $this->params['pid'];
        $data['order_expired'] = date('Y-m-d H:i:s',strtotime('+1 hour'));;
        $data['amount'] = 0;
        $data['term'] = 1;
        $data['count'] = 1;
        $data['status'] = 1;
        $data['create_ip'] = Utils::ipAddress();
        $data['create_at'] = date('Y-m-d H:i:s');
        $data['update_ip'] = Utils::ipAddress();
        $data['update_at'] = date('Y-m-d H:i:s');
        $result = UserOrderFactory::createOrder($data);

        //todo::插入task
        if ($result) {
            return $this->data;
        }
        return $this->error;
    }
}
