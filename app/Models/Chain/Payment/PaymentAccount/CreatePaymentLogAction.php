<?php

namespace App\Models\Chain\Payment\PaymentAccount;

use App\Helpers\Utils;
use App\Models\Chain\AbstractHandler;
use App\Models\Factory\Api\UserOrderFactory;
use App\Models\Orm\PaymentLog;
use App\Models\Orm\UserOrder;

class CreatePaymentLogAction extends AbstractHandler
{
    private $params = [];
    protected $error = ['error' => '创建订单payment_log失败！', 'code' => 8220];

    public function __construct($params)
    {
        $this->params = $params;
    }

    /**
     * 第一步:修改payment_log
     *
     * @return array
     */
    public function handleRequest()
    {
        if($this->createPaymentLog($this->params)){
            //根据订单号获取用户id
            $order = UserOrderFactory::getOrderDetailByOrderNo($this->params['orderId']);
            $this->params['user_id'] = $order['user_id'];
            $orderType = UserOrderFactory::getOrderTypeNidByTypeId($order['order_type']);
            $this->params['type'] = $orderType['type_nid'];

            $this->setSuccessor(new CreateUserAccountLogAction($this->params));
            return $this->getSuccessor()->handleRequest();
        }else{
            return $this->error;
        }
    }

    public function createPaymentLog($params)
    {
        $order_no = $params['orderId'];
        $response_data = json_encode($params);
        //根据订单号修改payment_log
        $data['response_data'] = $response_data;
        $data['status'] = 1;
        $data['update_at'] = date('Y-m-d H:i:s');
        $data['update_ip'] = Utils::ipAddress();
        $result = PaymentLog::where(['payment_order_no' => $order_no])->update($data);
        if ($result) {
            return true;
        }
        return false;
    }
}
