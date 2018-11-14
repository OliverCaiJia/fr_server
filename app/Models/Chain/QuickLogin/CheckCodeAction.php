<?php

namespace App\Models\Chain\QuickLogin;

use App\Models\Factory\Api\UserAuthFactory;
use App\Models\Chain\AbstractHandler;
use Cache;

class CheckCodeAction extends AbstractHandler
{

    private $params = array();
    protected $error = array('error' => '验证码输入不正确！', 'code' => 9000);

    public function __construct($params)
    {
        $this->params = $params;
    }

    /**
     *
     * 第二步:验证码是否正确
     * @return array
     */
    public function handleRequest()
    {
        if ($this->checkCode($this->params['mobile'], $this->params['code'], $this->params['sign']) == true)
        {
            $userAuth = UserAuthFactory::getUserByMobile($this->params['mobile']);
            $this->params['id'] = $userAuth['id']; //用户id
            $this->setSuccessor(new UpdateLoginTimeAction($this->params));
            return $this->getSuccessor()->handleRequest();
        }
        else
        {
            return $this->error;
        }
    }

    /**
     * 检查验证码是否正确
     */
    private function checkCode($mobile, $code, $sign)
    {
        #检查code以及sign
        $code_cache_key = 'login_phone_code_' . $mobile;
        $sign_cache_key = 'login_random_' . $mobile;

        if (Cache::has($code_cache_key) && Cache::has($sign_cache_key))
        {
            if (Cache::get($code_cache_key) == $code && Cache::get($sign_cache_key) == $sign)
            {
                return true;
            }
        }
        return false;
    }

}
