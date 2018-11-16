<?php

namespace App\Models\Chain\UserBank\Add;

use App\Models\Chain\AbstractHandler;
use App\Models\Orm\Bank;
use App\Services\Core\Validator\Bank\Alipay\AlipayBankService;

/**
 * Class SendImageToQiniuAction
 * @package App\Models\Chain\UserIdentity\IdcardFront
 * 获取银行卡开户银行信息
 */
class CheckBankCardAction extends AbstractHandler
{
    private $params = array();
    protected $error = array('error' => '暂不支持该银行或信用卡，请更换银行卡！', 'code' => 10003);

    public function __construct($params)
    {
        $this->params = $params;
    }

    /**
     * @return array
     * 是否支持该银行
     */
    public function handleRequest()
    {
        if ($this->checkBankCard($this->params) == true) {
            $this->setSuccessor(new CheckRealNameAction($this->params));
            return $this->getSuccessor()->handleRequest();
        } else {
            return $this->error;
        }
    }

    /**
     * @param $params
     * @return bool
     * 是否支持该银行
     */
    private function checkBankCard($params)
    {
        $bank_res = AlipayBankService::validateBankName($params['bankcard']);
        $support_bank = Bank::select('bank_code')->where('bank_code' ,'=', $bank_res['bank'])->first();
        //信用卡 CC 储蓄卡 DC
        if(!$support_bank || $support_bank['cardType'] == 'CC'){
            return false;
        }
        $this->params['bank_code'] = $bank_res['bank'];
        return true;
    }

}
