<?php

namespace App\Models\Chain\UserBank\Add;

use App\Models\Chain\AbstractHandler;
use App\Models\Factory\Api\UserRealnameFactory;

/**
 * Class CheckUserinfoAction
 * @package App\Models\Chain\Payment\Bankcard
 * 验证是否实名
 */
class CheckRealNameAction extends AbstractHandler
{
    private $params = array();
    protected $error = array('error' => '用户未实名！', 'code' => 10005);

    public function __construct($params)
    {
        $this->params = $params;
    }


    /**
     * 用户是否实名
     * @return array|bool
     */
    public function handleRequest()
    {
        if ($this->checkTianfour($this->params) == true) {
            $this->setSuccessor(new CheckTianfourAction($this->params));
            return $this->getSuccessor()->handleRequest();
        } else {
            return $this->error;
        }
    }


    /**
     * 用户是否实名
     * @param $params
     * @return bool
     */
    private function checkTianfour($params)
    {
        //获取用户信息
        $user = UserRealnameFactory::fetchUserRealname($params['user_id']);
        if($user){
            $this->params['real_name'] = $user['real_name'];
            $this->params['idcard'] = $user['id_card_no'];
            return true;
        }
        return  false;
    }
}
