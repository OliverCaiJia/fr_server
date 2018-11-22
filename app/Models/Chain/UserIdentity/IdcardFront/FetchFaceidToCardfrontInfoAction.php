<?php

namespace App\Models\Chain\UserIdentity\IdcardFront;


use App\Models\Chain\AbstractHandler;
use App\Services\Core\Message\OCR\FaceService;

/**
 * Class SendImageToQiniuAction
 * @package App\Models\Chain\UserIdentity\IdcardFront
 * 2.调用face++获取身份证正面信息
 */
class FetchFaceidToCardfrontInfoAction extends AbstractHandler
{
    private $params = array();
    protected $data = array();
    protected $error = array('error' => '验证失败，请使用身份证照片！', 'code' => 10003);

    public function __construct($params)
    {
        $this->params = $params;
    }

    /**
     * @return array
     * 2.调用face++获取身份证正面信息
     */
    public function handleRequest()
    {
        if ($this->fetchFaceidToCardfrontInfo($this->params) == true) {
            return $this->data;
        } else {
            return $this->error;
        }
    }

    /**
     * @param $params
     * @return bool
     * 2.调用face++获取身份证正面信息
     */
    private function fetchFaceidToCardfrontInfo($params)
    {
        $data_img = [
            'imgUrl' => $params['card_file'],
        ];
        $face_res = FaceService::o()->fetchBackOrFront($data_img);
        unlink($params['card_file']);
        if($face_res['result'] != '1002'){
            return false;
        }
        //数据整理
        $res = [
            'name' => $face_res['name']['result'],
            'gender' => $face_res['gender']['result'],
            'address' => $face_res['address']['result'],
            'idcard_number' => $face_res['idcard_number']['result'],
            'nationality' => $face_res['nationality']['result'],
            'idcard_url' => $params['signedUrl']
        ];
        $this->data = $res;
        return $res;
    }

}
