<?php

namespace App\Models\Chain\UserIdentity\CreateIdCard;

use App\Models\Chain\AbstractHandler;
use App\Services\Core\Validator\TianChuang\TianChuangService;

/**
 * Class CheckUserinfoAction
 * @package App\Models\Chain\Payment\Bankcard
 * 天创二要素验证
 */
class CheckTianTwoAction extends AbstractHandler
{
    private $params = array();
    protected $error = array('error' => '认证信息不匹配！', 'code' => 10005);

    public function __construct($params)
    {
        $this->params = $params;
    }


    /**
     * 天创二要素验证
     * @return array|bool
     */
    public function handleRequest()
    {
        if ($this->checkTiantwo($this->params) == true) {
            $this->setSuccessor(new UpdateUserInfoAction($this->params));
            return $this->getSuccessor()->handleRequest();
        } else {
            return $this->error;
        }
    }


    /**
     * 天创二要素验证
     * @param $params
     * @return bool
     */
    private function checkTiantwo($params)
    {
        //二要素验证
        $params = [
            'idcard' => $params['id_card_no'],
            'name' => $params['real_name'],
        ];

        $ret = json_decode(TianChuangService::authPersonalIdCard($params),true);
        //status Int 接口返回码,0-成功
        if ($ret['status'] != 0) {
            return false;
        } elseif ($ret['status'] == 0 && $ret['data']['result'] != 1) {
            //result Int 认证结果 1 认证成功 2 认证失败 3 未认证 4 已注销
            $this->error = array('error' => $ret['data']['detailMsg'], 'code' => 10005);
            return false;
        }

        return true;
    }
}
