<?php

namespace App\Models\Chain\UserIdentity\IdcardBack;

use App\Constants\UserIdentityConstant;
use App\Helpers\Logger\SLogger;
use App\Models\Chain\AbstractHandler;
use App\Services\Core\Message\OCR\FaceService;
use App\Services\Core\Store\Qiniu\QiniuService;
use App\Services\Core\Validator\FaceId\FaceIdService;
use App\Models\Chain\UserIdentity\IdcardBack\CreateUserRealnamLogAction;
use App\Strategies\UserIdentityStrategy;

/**
 * Class SendImageToQiniuAction
 * @package App\Models\Chain\UserIdentity\IdcardFront
 * 2.调用face++获取身份证反面信息
 */
class FetchFaceidToCardbackInfoAction extends AbstractHandler
{
    private $params = array();
    protected $data = array();
    protected $error = array('error' => '验证失败，请使用身份证照片！', 'code' => 10002);

    public function __construct($params)
    {
        $this->params = $params;
    }

    /**
     * @return array
     * 2.调用face++获取身份证反面信息
     */
    public function handleRequest()
    {
        if ($this->fetchFaceidToCardBackInfo($this->params) == true) {
            return $this->data;
        } else {
            return $this->error;
        }
    }

    /**
     * @param $params
     * @return bool
     * 2.调用face++获取身份证反面信息
     */
    private function fetchFaceidToCardBackInfo($params)
    {
        $data_img = [
            'imgUrl' => $params['card_file'],
        ];
        $face_res = FaceService::o()->fetchBackOrFront($data_img);
        unlink($params['card_file']);
        if($face_res['result'] != '1002'){
            return false;
        }
        $date = date('Ymd');
        if($date > $face_res['valid_date_end']['result']){
            return false;
        }
        //数据整理
        $res = [
            'valid_date_start' => $face_res['valid_date_start']['result'], //申请日期
            'issued_by' => $face_res['issued_by']['result'], //签发地
            'valid_date_end' => $face_res['valid_date_end']['result'], //失效日期
            'idcard_url' => $params['signedUrl']
        ];
        $this->data = $res;
        return $res;
    }

}
