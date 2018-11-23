<?php

namespace App\Models\Chain\UserIdentity\CreateIdCard;

use App\Models\Chain\AbstractHandler;
use App\Models\Factory\Api\UserinfoFactory;

/**
 * Class CheckUserinfoAction
 * @package App\Models\Chain\Payment\Bankcard
 * 修改用户信息
 */
class UpdateUserInfoAction extends AbstractHandler
{
    private $params = array();
    protected $error = array('error' => '认证信息不匹配！', 'code' => 10005);

    public function __construct($params)
    {
        $this->params = $params;
    }


    /**
     * 修改用户信息
     * @return array|bool
     */
    public function handleRequest()
    {
        if ($this->UpdateUserInfo($this->params) == true) {
            $this->setSuccessor(new CreateUserIdCardAction($this->params));
            return $this->getSuccessor()->handleRequest();
        } else {
            return $this->error;
        }
    }


    /**
     * 修改用户信息
     * @param $params
     * @return bool
     */
    private function UpdateUserInfo($params)
    {
        $data = ['service_status' => 1];
        $userInfo = UserinfoFactory::UpdateUserInfoStatus($params['user_id'],$data);
        return $userInfo ? true : false;
    }
}
