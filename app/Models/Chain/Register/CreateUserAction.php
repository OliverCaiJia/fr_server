<?php
namespace App\Models\Chain\Register;

use App\Helpers\Utils;
use App\Models\Factory\Api\UserAuthFactory;
use App\Models\Chain\AbstractHandler;
use App\Helpers\Generator\TokenGenerator;

class CreateUserAction extends AbstractHandler
{
    private $params = array();
    protected $error = array('error' => '对不起,用户注册失败！', 'code' => 111);
    protected $data;
    protected  $user;

    public function __construct($params)
    {
        $this->params = $params;
    }



    /**
     * 创建用户
     * @return array|bool
     */
    public function handleRequest()
    {
        if ($this->createUser($this->params) == true)
        {
            $this->params['id'] = UserAuthFactory::getUserIdByMobile($this->params['mobile']);
            $this->setSuccessor(new  CreateUserInfoAction($this->params));
            return $this->getSuccessor()->handleRequest();
        }
        else
        {
            return $this->error;
        }
    }


    /**
     * 用户主表sd_user_auth中存数据
     * @param $params
     * @return bool
     */
    private function createUser($params)
    {
        $data = [
            'user_name' => $params['mobile'],
            'mobile' => $params['mobile'],
            'password' => '',
            'auth_key' => '',
            'access_token' => TokenGenerator::generateToken(),
            'expire_at' => date('Y-m-d H:i:s',strtotime('+1year')),
            'create_at' => date('Y-m-d H:i:s', time()),
            'create_ip' => Utils::ipAddress(),
            'last_login_at' => date('Y-m-d H:i:s', time()),
            'last_login_ip' => Utils::ipAddress(),
        ];
        $invite['invite_code'] = isset($data['invite_code']) ? $data['invite_code'] : ''; //邀请码
        $user = UserAuthFactory::createUser($data);
        return $user ? true : false;
    }
}
