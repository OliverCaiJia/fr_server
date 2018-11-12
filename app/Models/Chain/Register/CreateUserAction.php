<?php
namespace App\Models\Chain\Register;

use App\Helpers\Utils;
use App\Models\Factory\Api\UserAuthFactory;
use App\Helpers\Generator\TokenGenerator;
use App\Models\Chain\AbstractHandler;

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
			return $this->user;
		}
		else
		{
			return $this->error;
		}
	}
	
	
	/**
	 * 用户主表sgd_user_auth中存数据
	 * @param $params
	 * @return bool
	 */
	private function createUser($params)
	{
	    //数据整合
        $data['user_name'] = $params['mobile'];
        $data['mobile'] = $params['mobile'];
        $data['password'] = $params['password'];
        $data['status'] = 1;
        $data['auth_key'] = '4865';
        $data['access_token'] = TokenGenerator::generateToken();
        $data['create_at'] = date('Y-m-d H:i:s');
        $data['create_ip'] = Utils::ipAddress();
        $data['last_login_at'] = date('Y-m-d H:i:s');
        $data['last_login_ip'] = Utils::ipAddress();

		$this->user = UserAuthFactory::createUser($data);
        return $this->user;
	}
}
