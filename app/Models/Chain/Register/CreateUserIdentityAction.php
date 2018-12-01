<?php

namespace App\Models\Chain\Register;

use App\Helpers\Utils;
use App\Models\Chain\AbstractHandler;
use App\Models\Factory\Api\InviteFactory;

class CreateUserIdentityAction extends AbstractHandler
{

    private $params = array();
    protected $error = array('error' => '创建用户身份信息出错！', 'code' => 111);
    protected $data;

    public function __construct($params)
    {
        $this->params = $params;
    }

    /**
     * @return array|bool
     */
    public function handleRequest()
    {
        if ($this->createUserIdentity($this->params) == true)
        {
            $this->setSuccessor(new RenovateTokenAction($this->params));
            return $this->getSuccessor()->handleRequest();
        }
        else
        {
            return $this->error;
        }
    }

    /**
     * @desc 创建用户身份
     * @param $params
     */
    public function createUserIdentity($params)
    {
        if (isset($params['invite_code']) && !empty($params['invite_code'])) {
            //如果邀请码存在并且不为空,则根据邀请码获得邀请人id
            $user_id = InviteFactory::fetchInviteUserIdByCode($params['invite_code']);
            if($user_id){
                $params['user_id'] = $user_id;
                $userInvite = InviteFactory::createUserInvite($params);
                return $userInvite ? true : false;
            }else{
                return false;
            }
        }
        return true;
    }

}
