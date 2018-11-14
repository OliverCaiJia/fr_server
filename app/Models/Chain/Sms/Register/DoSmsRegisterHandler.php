<?php
namespace App\Models\Chain\Sms\Register;

use App\Models\Chain\AbstractHandler;

/**
 * 短信注册
 */
class DoSmsRegisterHandler extends AbstractHandler
{
    #外部传参

    private $params = array();

    public function __construct($params)
    {
        $this->params = $params;
        $this->setSuccessor($this);
    }

    /**
     * 第一步:发送注册短信
     * 第二步:存短信信息进cache
     *
     */

    /**
     *
     * @return mixed]
     */
    public function handleRequest()
    {
        $this->setSuccessor(new SendRegisterSmsAction($this->params));
        return $this->getSuccessor()->handleRequest();
    }

}
