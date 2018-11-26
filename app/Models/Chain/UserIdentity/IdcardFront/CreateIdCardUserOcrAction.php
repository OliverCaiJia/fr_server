<?php

namespace App\Models\Chain\UserIdentity\IdcardFront;


use App\Models\Chain\AbstractHandler;
use App\Models\Orm\UserOcrLog;

/**
 * Class SendImageToQiniuAction
 * @package App\Models\Chain\UserIdentity\IdcardFront
 * 记录身份证数据信息
 */
class CreateIdCardUserOcrAction extends AbstractHandler
{
    private $params = array();
    protected $data = array();
    protected $error = array('error' => '身份证验证失败，请重新验证！', 'code' => 10003);

    public function __construct($params)
    {
        $this->params = $params;
    }

    /**
     * @return array
     * 记录身份证数据信息
     */
    public function handleRequest()
    {
        if ($this->createUserOcrCardfrontInfo($this->params) == true) {
            return $this->data;
        } else {
            return $this->error;
        }
    }

    /**
     * @param $params
     * @return bool
     * 记录身份证数据信息
     */
    private function createUserOcrCardfrontInfo($params)
    {
       $insertData = [
           'user_id' => $params['user_id'],
           'request_id' => $params['request_id'],
           'side' => $params['side'],
           'status' => 0,
           'legality' => $params['legality'],
           'completeness' => $params['completeness'],
           'card_rect' => $params['card_rect'],
           'error' => $params['error'],
           'create_at' => date('Y-m-d H:i:s'),
           'update_at' => date('Y-m-d H:i:s'),
       ];

       $res = UserOcrLog::insert($insertData);
       if(!$res){
           return false;
       }

        $this->data = $res;
        //数据整理
        $res = [
            'name' => $params['name'],
            'gender' => $params['gender'],
            'address' => $params['address'],
            'idcard_number' => $params['idcard_number'],
            'nationality' => $params['nationality'],
            'idcard_url' => $params['signedUrl']
        ];

        $this->data = $res;
        return $res;
    }

}
