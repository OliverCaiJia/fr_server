<?php

namespace App\Models\Chain\Register;

use App\Helpers\Utils;
use App\Models\Chain\AbstractHandler;
use App\Models\Orm\Channel;
use App\Models\Orm\UserChannel;

class CreateUserChannelAction extends AbstractHandler
{

    private $params = array();
    protected $error = array('error' => '邀请用户不合法！', 'code' => 111);
    protected $data;

    public function __construct($params)
    {
        $this->params = $params;
    }

    /**
     * @return array|bool
     */
    public function handleRequest()
    {
        if ($this->createUserChannel($this->params) == true)
        {
            $this->setSuccessor(new RenovateTokenAction($this->params));
            return $this->getSuccessor()->handleRequest();
        }
        else
        {
            return $this->error;
        }
    }

    /**
     * @desc 创建用户渠道
     * @param $params
     */
    public function createUserChannel($params)
    {
        $channel_nid = isset($params['channel_nid']) ? $params['channel_nid'] : '';
        $channel_id = Channel::select('id')->where('channel_nid', '=', $channel_nid)->first();
        if(!$channel_id->id){
            $channel_id = Channel::select('id')->where('channel_nid', '=', 'channel_001')->first();
            if(!$channel_id->id) return false;
        }
        $data = [
            'user_id' => $params['id'],
            'channel_id' => $channel_id->id,
            'create_at' => date('Y-m-d H:i:s'),
            'create_ip' => Utils::ipAddress(),
            'update_at' => date('Y-m-d H:i:s'),
            'update_ip' => Utils::ipAddress(),
        ];
        $userChannel = UserChannel::insert($data);
        return $userChannel ? true : false;


    }

}
