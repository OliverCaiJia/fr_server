<?php

namespace App\Models\Chain\Payment\PaymentAccount;

use App\Models\Chain\AbstractHandler;
use App\Models\Factory\Api\UserOrderFactory;
use App\Models\Orm\UserAccountLog;
use App\Models\Orm\UserOrder;
use App\Helpers\Utils;

class CreateUserAccountLogAction extends AbstractHandler
{
    private $params = [];
    protected $error = ['error' => '创建订单user_account_log失败！', 'code' => 8220];

    public function __construct($params)
    {
        $this->params = $params;
    }

    /**
     * 第二步:修改user_account_log
     *
     * @return array
     */
    public function handleRequest()
    {
        if($this->createUserAccountLog($this->params)){
            $this->setSuccessor(new CreateUserAccountAction($this->params));
            return $this->getSuccessor()->handleRequest();
        }else{
            return $this->error;
        }
    }

    public function createUserAccountLog($params)
    {
        $accountLog = new UserAccountLog();

        $accountLog->nid_no = $params['orderId'];
        $accountLog->user_id = $params['user_id'];
        $accountLog->type = $params['type'];
        $accountLog->status = 1;
        $accountLog->money = $params['orderAmount'];
        $accountLog->expend = $params['payAmount'];
        $accountLog->create_at = date('Y-m-d H:i:s');
        $accountLog->create_ip = Utils::ipAddress();
        $result = $accountLog->save();
        if ($result) {
            return true;
        }
        return false;
    }
}
