<?php

namespace App\Models\Chain\Order\NoPayOrder\ApplyOrder;

use App\Models\Chain\AbstractHandler;
use App\Models\Chain\Order\Loan\CreateApplyUserOrderAction;

class CreatePushTaskAction extends AbstractHandler
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
            $this->setSuccessor(new CreateApplyUserOrderAction($this->params));
            return $this->getSuccessor()->handleRequest();
        } else {
            return $this->error;
        }
    }

    private function checkCount($params)
    {
        //todo::入task_loan表
        $count = 1;
        if ($count != 1) {//处理中
            $this->error['error'] = "您好，订单数量必须是一！";
            return false;
        }
        return true;
    }
}
