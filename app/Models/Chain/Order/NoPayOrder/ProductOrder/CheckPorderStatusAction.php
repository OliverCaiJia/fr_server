<?php

namespace App\Models\Chain\Order\NoPayOrder\ProductOrder;

use App\Constants\OrderConstant;
use App\Helpers\Utils;
use App\Models\Chain\AbstractHandler;
use App\Models\Factory\Api\UserOrderFactory;
use App\Strategies\UserOrderStrategy;

class CheckPorderStatusAction extends AbstractHandler
{
    private $params = [];
    protected $error = ['error' => '订单状态不合法，审核（拒绝）失败！', 'code' => 8210];

    public function __construct($params)
    {
        $this->params = $params;
    }

    /**
     * 第一步:
     *
     * @return array
     */
    public function handleRequest()
    {
        if ($this->checkStatus($this->params)) {
            $this->setSuccessor(new CreateProductOrderAction($this->params));
            return $this->getSuccessor()->handleRequest();
        } else {
            return $this->error;
        }
    }

    private function checkStatus($params)
    {
        $orderNo = $params['order_no'];
        $userOrder = UserOrderFactory::getUserOrderByOrderNo($orderNo);
        if (empty($userOrder)) {
            $this->error['error'] = "订单:{$orderNo}，此订单不存在！";
            return false;
        }
        $orderType = $userOrder['order_type'];
        $userOrderType = UserOrderFactory::getOrderTypeById($orderType);
        $typeNid = $userOrderType['type_nid'];
        $pOrderId = $userOrder['p_order_id'];
        if ($typeNid != 'order_extra_service' || $pOrderId != 0) {
            $this->error['error'] = "订单:{$orderNo}，此订单不是增值订单，不能赠送服务！";
            return false;
        }
        $status = $userOrder['status'];
        if ($status != 1) {
            $this->error['error'] = "订单:{$orderNo}，此订单不是处理完成状态，不能赠送服务！";
            return false;
        }
        $orderTypeNidSub = 'order_product';
        $userOrderType = UserOrderFactory::getOrderTypeByTypeNid($orderTypeNidSub);
        $this->params['user_id'] = $userOrder['user_id'];
        $this->params['payment_log_id'] = 0;
        $this->params['order_no'] = UserOrderStrategy::createOrderNo();
        $this->params['order_type'] = $userOrderType['id'];
        $this->params['p_order_id'] = $userOrder['id'];
        $this->params['order_expired'] = $userOrder['order_expired'];
        $this->params['term'] = 0;
        $this->params['status'] = 1;
        $this->params['create_ip'] = Utils::ipAddress();
        $this->params['create_at'] = date('Y-m-d H:i:s', time());
        $this->params['update_ip'] = Utils::ipAddress();
        $this->params['update_at'] = date('Y-m-d H:i:s', time());
        return true;
    }
}
