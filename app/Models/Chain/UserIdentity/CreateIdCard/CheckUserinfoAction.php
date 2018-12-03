<?php
namespace App\Models\Chain\UserIdentity\CreateIdCard;

use App\Models\Chain\AbstractHandler;
use App\Models\Orm\UserAuth;

/**
 * Class CheckUserinfoAction
 * @package App\Models\Chain\Payment\Bankcard
 * 1.验证用户信息，获取用户信息
 */
class CheckUserinfoAction extends AbstractHandler
{
    private $params = array();
    protected $error = array('error' => '用户未认证！', 'code' => 10001);

    public function __construct($params)
    {
        $this->params = $params;
    }



    /**
     * 验证用户是否存在,是否激活
     * @return array|bool
     */
    public function handleRequest()
    {
        if ($this->checkUserinfo($this->params) == true)
        {
            $this->setSuccessor(new CheckIdCardDateAction($this->params));
            return $this->getSuccessor()->handleRequest();
        }
        else
        {
            return $this->error;
        }
    }


    /**
     * 验证用户是否存在，是否激活
     * @param $params
     * @return bool
     */
    private function checkUserinfo($params)
    {
        $user = UserAuth::select("id")->where('id', '=', $params['user_id'])->where('status','=',1)->first();

        return $user ? true : false;

    }
}
