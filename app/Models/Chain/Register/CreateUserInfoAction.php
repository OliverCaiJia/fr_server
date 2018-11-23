<?php

namespace App\Models\Chain\Register;

use App\Models\Chain\AbstractHandler;
use App\Models\Factory\Api\UserinfoFactory;

class CreateUserInfoAction extends AbstractHandler
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
            $this->setSuccessor(new CreateUserIdentityAction($this->params));
            return $this->getSuccessor()->handleRequest();
        }
        else
        {
            return $this->error;
        }
    }

    /**
     * @desc 创建用户身份user_info 插入数据
     * @param $params
     */
    public function createUserIdentity($params)
    {
        $data = [
            'user_id' => $params['id'],
            'dev_type' => isset($params['dev_type']) ? $params['dev_type'] : 0,
            'dev_model' => isset($params['dev_model']) ? $params['dev_model'] : '',
            'dev_version' => isset($params['dev_version']) ? $params['dev_version'] : '',
            'status' => 1,
            'service_status' => 0,
            'has_userinfo' => 0,
            'create_at' => date('Y-m-d H:i:s', time()),
            'update_at' => date('Y-m-d H:i:s', time()),
        ];
        $userInfo = UserinfoFactory::createUserInfo($data);
        return $userInfo ? true : false;
    }

}
