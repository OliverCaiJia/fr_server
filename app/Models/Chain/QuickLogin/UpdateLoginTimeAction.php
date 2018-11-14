<?php

namespace App\Models\Chain\QuickLogin;

use App\Models\Factory\Api\UserAuthFactory;
use App\Models\Chain\AbstractHandler;

class UpdateLoginTimeAction extends AbstractHandler
{

    private $params = array();
    protected $error = array('error' => '用户登录失败!', 'code' => 9001);

    public function __construct($params)
    {
        $this->params = $params;
    }

    /** 更新用户最后登录时间
     * @return array
     */
    public function handleRequest()
    {
        if ($this->updateLoginTime($this->params['id']) == true)
        {
            $this->setSuccessor(new RenovateTokenAction($this->params));
            return $this->getSuccessor()->handleRequest();
        }
        else
        {
            return true;
        }
    }

    /** sd_user_auth更新操作
     * @param $params
     */
    private function updateLoginTime($params)
    {
        return UserAuthFactory::updateLoginTime($params);
    }

}
