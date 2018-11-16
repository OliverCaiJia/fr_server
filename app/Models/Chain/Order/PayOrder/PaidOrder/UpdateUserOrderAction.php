<?php

namespace App\Models\Chain\Order\PayOrder\PaidOrder;

use App\Constants\OrderConstant;
use App\Helpers\Utils;
use App\Models\Chain\AbstractHandler;
use App\Models\Factory\Api\UserOrderFactory;

class UpdateUserOrderAction extends AbstractHandler
{
    private $params = [];
    protected $error = ['error' => '订单状态不合法，审核（拒绝）失败！', 'code' => 8210];

    public function __construct($params)
    {
        $this->params = $params;
    }

    public function handleRequest()
    {
        $para = $this->params;
        $userId = $para['user_id'];
        $orderNo = $para['order_no'];
        $data['status'] = $para['status'];
        $data['update_ip'] = Utils::ipAddress();
        $data['update_at'] = date('Y-m-d H:i:s', time());
        $result = UserOrderFactory::updateOrderByUserIdAndOrderNo($userId, $orderNo, $data);
        if ($result) {
            return true;
        }
        return $this->error;
    }
}
