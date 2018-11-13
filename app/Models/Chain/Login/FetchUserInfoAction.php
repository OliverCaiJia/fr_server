<?php

namespace App\Models\Chain\Login;

use App\Models\Factory\Api\UserAuthFactory;
use App\Models\Factory\AuthFactory;
use App\Models\Factory\UserFactory;
use App\Models\Chain\AbstractHandler;

class FetchUserInfoAction extends AbstractHandler
{

    private $params = array();
    protected $error = array('error' => '用户登录失败!!', 'code' => 9004);
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

    /*
    * 合并用户信息数组并返回
     * @param $params
     * @return bool
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
