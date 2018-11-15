<?php

namespace App\Models\Chain\UserBank\Defaultcard;

use App\Models\Chain\AbstractHandler;
use App\Models\Factory\Api\UserBankcardFactory;

/**
 * 1.取消默认储蓄卡
 * Class CheckUserinfoAction
 * @package App\Models\Chain\Payment\Bankcard
 *
 */
class DeleteDefaultAction extends AbstractHandler
{
    private $params = array();
    protected $error = array('error' => '取消默认失败！', 'code' => 10001);

    public function __construct($params)
    {
        $this->params = $params;
    }


    /**
     * 取消默认储蓄卡
     * @return array|bool
     */
    public function handleRequest()
    {
        if ($this->deleteDefault($this->params) == true) {
            $this->setSuccessor(new UpdateCardDefaultAction($this->params));
            return $this->getSuccessor()->handleRequest();
        } else {
            return $this->error;
        }
    }


    /**
     * 取消默认储蓄卡
     * @param $params
     * @return bool
     */
    private function deleteDefault($params)
    {
        //获得用户默认银行卡id
        $defaultCardIds = UserBankcardFactory::getDefaultBankCardIdById($params['userId']);
        $params['ids'] = $defaultCardIds;
        if($params['ids']){
            //取消默认卡
            $del = UserBankcardFactory::deleteDefaultById($params);
            return $del;
        }
        return true;

    }
}
