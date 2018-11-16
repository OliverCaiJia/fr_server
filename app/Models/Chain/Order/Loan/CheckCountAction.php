<?php

namespace App\Models\Chain\Order\Loan;

use App\Models\Chain\AbstractHandler;

class CheckCountAction extends AbstractHandler
{
    private $params = [];
    protected $error = ['error' => '订单数量必须是1！', 'code' => 8210];

    public function __construct($params)
    {
        $this->params = $params;
    }


    public function handleRequest()
    {
        if ($this->checkCount($this->params)) {
            $this->setSuccessor(new CreateUserOrderrAction($this->params));
            return $this->getSuccessor()->handleRequest();
        } else {
            return $this->error;
        }
    }

    private function checkCount($params)
    {
        $count = $params['count'];
        if ($count != 1) {//处理中
            $this->error['error'] = "您好，订单数量必须是一！";
            return false;
        }
        return true;
    }
}
