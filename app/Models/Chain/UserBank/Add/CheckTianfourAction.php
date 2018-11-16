<?php

namespace App\Models\Chain\UserBank\Add;

use App\Models\Chain\AbstractHandler;
use App\Services\Core\Validator\TianChuang\TianChuangService;

/**
 * Class CheckUserinfoAction
 * @package App\Models\Chain\Payment\Bankcard
 * 天创四要素验证
 */
class CheckTianfourAction extends AbstractHandler
{
    private $params = array();
    protected $error = array('error' => '认证信息不匹配！', 'code' => 10005);

    public function __construct($params)
    {
        $this->params = $params;
    }


    /**
     * 天创四要素验证
     * @return array|bool
     */
    public function handleRequest()
    {
        if ($this->checkTianfour($this->params) == true) {
            $this->setSuccessor(new CreateUserBanksAction($this->params));
            return $this->getSuccessor()->handleRequest();
        } else {
            return $this->error;
        }
    }


    /**
     * 天创四要素验证
     * @param $params
     * @return bool
     */
    private function checkTianfour($params)
    {
        //获取用户信息
        //四要素验证
        $params = [
            'idcard' => $params['idcard'],
            'name' => $params['real_name'],
            'bankcard' => $params['bankcard'],
            'mobile' => $params['mobile'],
        ];

        $ret = json_decode(TianChuangService::authFourthElements($params),true);
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
