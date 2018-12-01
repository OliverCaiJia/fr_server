<?php

namespace App\Models\Chain\Payment\PaymentAccount;

use App\Helpers\Utils;
use App\Models\Chain\AbstractHandler;
use App\Models\Factory\Api\AccountFactory;
use App\Models\Factory\Api\UserOrderFactory;
use App\Models\Orm\UserAccount;
use App\Models\Orm\UserOrder;

class CreateUserAccountAction extends AbstractHandler
{
    private $params = [];
    protected $error = ['error' => '创建订单user_account失败！', 'code' => 8220];

    public function __construct($params)
    {
        $this->params = $params;
        //设置用户初始状态
        $this->params['status'] = 1;
    }

    /**
     * 第三步:修改user_account
     *
     * @return array
     */
    public function handleRequest()
    {
        if($this->createUserAccount($this->params)){
            return true;
        }else{
            return $this->error;
        }
    }

    public function createUserAccount($params)
    {
        //获取当前用户账户
        $result = AccountFactory::createUserAccount($params);
        if ($result) {
            return true;
        }
        return false;
    }
}
