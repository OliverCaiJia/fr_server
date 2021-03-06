<?php

namespace App\Models\Chain\QuickLogin;

use App\Models\Orm\UserAuth;
use App\Models\Chain\AbstractHandler;

class CheckUserLockAction extends AbstractHandler
{

    private $params = array();
    protected $error = array('error' => '该用户被锁定，请联系水果贷官方客服!', 'code' => 403403);

    public function __construct($params)
    {
        $this->params = $params;
    }

    /*
     *第二步:检查用户是否被锁定
     * @return array
     */

    public function handleRequest()
    {
        if ($this->checkUserLock($this->params['mobile']) == true)
        {
            $this->setSuccessor(new CheckCodeAction($this->params));
            return $this->getSuccessor()->handleRequest();
        }
        else
        {
            return $this->error;
        }
    }

    /**
     * 查数据库确认用户信息是否被锁定
     */
    private function checkUserLock($mobile)
    {
        $user = UserAuth::select("mobile")->where('mobile', '=', $mobile)->where('status','=',1)->first();
        return $user ? true : false;
    }

}
