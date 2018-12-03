<?php

namespace App\Models\Chain\QuickLogin;

use App\Models\Factory\Api\UserAuthFactory;
use App\Models\Chain\AbstractHandler;
use Cache;
use Carbon\Carbon;
use App\Helpers\Generator\TokenGenerator;

class RenovateTokenAction extends AbstractHandler
{

    private $params = array();
    protected $error = array('error' => '更新token失败!!', 'code' => 9003);

    public function __construct($params)
    {
        $this->params = $params;
    }

    /*
     * 刷新用户token
     * @return array
     */

    public function handleRequest()
    {
        if ($this->renovateToken($this->params) == true)
        {
            $this->setSuccessor(new FetchUserInfoAction($this->params));
            return $this->getSuccessor()->handleRequest();
        }
        else
        {
            return true;
        }
    }
	
	/**
	 * 刷新用户token
	 * @param $params
	 * @return bool
	 */
    private function renovateToken($params)
    {
	    $user = UserAuthFactory::getUserById($params['id']);
        if (!empty($user))
        {
            $user_id = $user['id'];
            $access_token = TokenGenerator::generateToken();

           $user_res = UserAuthFactory::updateUserTokenById($user_id,$access_token);
           if($user_res){
               return true;
           }
            return false;
        }
        return false;
    }

}
