<?php
namespace App\Models\Chain\Sms\Register;

use App\Helpers\Generator\TokenGenerator;
use App\Models\Chain\AbstractHandler;
use App\Services\Core\Message\Sms\Chuanglan\ChuanglanService;

class SendRegisterSmsAction extends AbstractHandler
{

    private $params = array();
    protected $error = array('error' => '短信验证码下发已超上限', 'code' => 3);
    protected $randoms;

    public function __construct($params)
    {
        $this->params = $params;
    }

    /**
     * @return array
     * 发送注册短信
     */
    public function handleRequest()
    {
        if ($this->sendRegisterSms($this->params) == true) {
            $this->setSuccessor(new PutValueToCacheAction($this->params,$this->randoms));
            return $this->getSuccessor()->handleRequest();
        } else {
            return $this->error;
        }
    }

    /**
     * @param $params
     * 发送注册短信
     */
    private function sendRegisterSms($params)
    {
        #生成四位数字短信验证码
        $code = mt_rand(100000, 999999);
        #组织短信验证码内容
        $data['phone'] = $params['mobile'];
        $data['msg'] = "【水果贷】您的验证码是{$code},请勿将验证码提供给他人，若非本人操作可忽略";
        #调取发送方法
        $re = json_decode(ChuanglanService::send($data),true);
        #生成32位随机字符串
        $random = [];
        $random['sign'] = TokenGenerator::generateToken();

        $this->randoms = $random;
        $this->params['code'] = $code;

        if($re['code'] != 0) {
            return false;
        }

        return true;
    }



}
