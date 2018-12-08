<?php

namespace App\Models\Chain\UserIdentity\IdcardBack;

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
        if ($this->createUserOcrCardbackInfo($this->params) == true) {
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
    private function createUserOcrCardbackInfo($params)
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
            'valid_date_start' => date('Y-m-d',strtotime($params['valid_date_start'])),
            'issued_by' => $params['issued_by'],
            'valid_date_end' => date('Y-m-d',strtotime($params['valid_date_end'])),
            'idcard_url' => $params['signedUrl']
        ];

        $this->data = $res;
        return $res;
    }

}
