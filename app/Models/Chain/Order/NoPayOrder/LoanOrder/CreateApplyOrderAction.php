<?php

namespace App\Models\Chain\Order\NoPayOrder\LoanOrder;

use App\Constants\UserOrderConstant;
use App\Helpers\Logger\SLogger;
use App\Helpers\Utils;
use App\Models\Chain\AbstractHandler;
use App\Models\Factory\Api\UserOrderFactory;
use App\Models\Orm\UserOrderType;
use App\Strategies\UserOrderStrategy;

class CreateApplyOrderAction extends AbstractHandler
{
    private $params = [];
    protected $error = ['error' => '您好，订单还未付费！', 'code' => 8010];

    public function __construct($params)
    {
        $this->params = $params;
    }


    public function handleRequest()
    {
        if ($this->createApplyOrder($this->params)) {
            $this->setSuccessor(new CreatePushTaskAction($this->params));
            return $this->getSuccessor()->handleRequest();
        } else {
            return $this->error;
        }
    }

    private function createApplyOrder($params)
    {
        SLogger::getStream()->info(__CLASS__);
        $data = [];
        $data['user_id'] = $params['user_id'];
        $orderTypeNid = 'order_apply';
        $extra = UserOrderStrategy::getExtra($orderTypeNid);
        $data['order_no'] = UserOrderStrategy::createOrderNo($extra);
        $orderType = UserOrderFactory::getOrderTypeByTypeNid($orderTypeNid);
        $data['order_type'] = $orderType['id'];
        $data['p_order_id'] = 0;//没有父级订单
        $data['order_expired'] = date('Y-m-d H:i:s', strtotime('+1 hour'));
        $data['amount'] = 0;//免费订单金额为零
        $borrowLog = UserOrderFactory::getBorrowLogByUserId($params['user_id']);
        $data['money'] = $borrowLog['loan_amount'];
        $data['term'] = $borrowLog['loan_peroid'];
        $data['count'] = 1;//订单数量为一
        $data['status'] = 1;//订单状态（默认）为已支付
        $data['create_ip'] = Utils::ipAddress();
        $data['create_at'] = date('Y-m-d H:i:s', time());
        $data['update_ip'] = Utils::ipAddress();
        $data['update_at'] = date('Y-m-d H:i:s', time());
        $result = UserOrderFactory::createOrder($data);
        $this->params['order_no'] = $result['order_no'];
        if (empty($result)) {
            $this->error['error'] = "用户您好，贷款订单没有生成.";
            return false;
        }
        return true;
    }
}
