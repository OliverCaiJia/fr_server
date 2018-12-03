<?php
namespace App\Models\Chain\UserIdentity\CreateIdCard;

use App\Models\Chain\AbstractHandler;
use App\Models\Orm\UserAuth;

/**
 * Class CheckUserinfoAction
 * @package App\Models\Chain\Payment\Bankcard
 * 验证用户身份证是否过期
 */
class CheckIdCardDateAction extends AbstractHandler
{
    private $params = array();
    protected $error = array('error' => '用户身份证已过期！', 'code' => 10001);

    public function __construct($params)
    {
        $this->params = $params;
    }



    /**
     * 验证用户身份证是否过期
     * @return array|bool
     */
    public function handleRequest()
    {
        if ($this->checkIdCardDate($this->params) == true)
        {
            $this->setSuccessor(new CheckUserIdCardAction($this->params));
            return $this->getSuccessor()->handleRequest();
        }
        else
        {
            return $this->error;
        }
    }


    /**
     * 验证用户身份证是否过期
     * @param $params
     * @return bool
     */
    private function checkIdCardDate($params)
    {
        if(strtotime($params['valid_end_date']) < strtotime(date('Y-m-d'))){
            return false;
        }
        return true;
    }
}
