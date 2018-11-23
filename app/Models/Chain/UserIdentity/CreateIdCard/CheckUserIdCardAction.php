<?php

namespace App\Models\Chain\UserIdentity\CreateIdCard;

use App\Models\Chain\AbstractHandler;
use App\Models\Factory\Api\UserRealnameFactory;

/**
 * 2.验证用户身份证是否存在
 * Class CheckUserinfoAction
 * @package App\Models\Chain\Payment\Bankcard
 *
 */
class CheckUserIdCardAction extends AbstractHandler
{
    private $params = array();
    protected $error = array('error' => '用户身份证已存在！', 'code' => 10002);

    public function __construct($params)
    {
        $this->params = $params;
    }


    /**
     * 验证用户身份证是否存在
     * @return array|bool
     */
    public function handleRequest()
    {
        if ($this->checkUserBank($this->params) == true) {
            $this->setSuccessor(new CheckTianTwoAction($this->params));
            return $this->getSuccessor()->handleRequest();
        } else {
            return $this->error;
        }
    }


    /**
     * 验证用户身份证是否存在
     * @param $params
     * @return bool
     */
    private function checkUserBank($params)
    {
        $userIdCard= UserRealnameFactory::fetchUserRealname($params['user_id']);
            //用户身份证已存在
            if (!empty($userIdCard)) {
                return false;
            }
            return true;
        }
    }
