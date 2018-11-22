<?php

namespace App\Models\Chain\Order\NoPayOrder\ProductOrder;

use App\Helpers\Utils;
use App\Models\Chain\AbstractHandler;
use App\Models\Factory\Admin\Order\OrderFactory;
use App\Models\Factory\Api\UserOrderFactory;
use App\Strategies\UserOrderStrategy;

class CreateProductOrderAction extends AbstractHandler
{
    private $params = [];
    protected $error = ['error' => '记录拒绝理由失败，审核（拒绝）失败！', 'code' => 8220];

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
        $orderType = UserOrderFactory::getOrderTypeByTypeNid($this->params['order_type_nid']);
        $data['order_type'] = $orderType['id'];
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

        $result = UserOrderFactory::createOrder($this->params);
        if ($result) {
            return $this->data;
        }
        return false;
    }
}
