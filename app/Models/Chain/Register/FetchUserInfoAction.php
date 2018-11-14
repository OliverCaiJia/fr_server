<?php

namespace App\Models\Chain\Register;

use App\Models\Factory\Api\UserAuthFactory;
use App\Models\Factory\UserFactory;
use App\Models\Chain\AbstractHandler;

class FetchUserInfoAction extends AbstractHandler
{

    private $params = array();
    protected $error = array('error' => '用户登录失败!!', 'code' => 9003);
    protected $data;

    public function __construct($params)
    {
        $this->params = $params;
    }

    /*
     * 返回个人信息
     * @return array
     */

    public function handleRequest()
    {
        if ($this->getUserInfo($this->params) == true)
        {
	        return $this->data;
        }
        else
        {
            return $this->error;
        }
    }

    /**
     * 查数据库返回个人信息
     * @param $params
     */
    private function getUserInfo($params)
    {
        $info = UserAuthFactory::getUserById($params['id']);
        if ($info)
        {
            $this->data = $info;
            return true;
        }
        return false;
    }

}
