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
    protected $error = array('error' => '验证失败，请重新验证！', 'code' => 10003);

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
            $this->setSuccessor(new CreateIdCardUserOcrAction($this->params));
            return $this->getSuccessor()->handleRequest();
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
        if(isset($face_res['ERROR'])){
            return false;
        }
        $this->params['request_id'] = $face_res['request_id'];
        $this->params['side'] = $face_res['side'];
        $this->params['completeness'] = $face_res['completeness'];
        $this->params['card_rect'] = json_encode($face_res['card_rect']);
        $this->params['legality'] = json_encode($face_res['legality']);
        $this->params['error'] = isset($face_res['ERROR']) ? $face_res['ERROR'] : '';
        $this->params['name'] = $face_res['name']['result'];
        $this->params['gender'] = $face_res['gender']['result'];
        $this->params['address'] = $face_res['address']['result'];
        $this->params['idcard_number'] = $face_res['idcard_number']['result'];
        $this->params['nationality'] = $face_res['nationality']['result'];

        return true;
    }

}
