<?php

namespace App\Models\Chain\UserBank\Add;

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
        if ($this->updateUserInfo($this->params) == true) {
            $this->setSuccessor(new CreateUserBanksAction($this->params));
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
    private function updateUserInfo($params)
    {
        //获取当前状态
        $userInfoRes = UserinfoFactory::getUserInfoByUserId($params['user_id']);
        if ($userInfoRes['service_status'] == 1) {
            $data = ['service_status' => 2];
            $userInfo = UserinfoFactory::updateUserInfoStatus($params['user_id'], $data);
            return $userInfo ? true : false;
        }

        return true;

    }
}
