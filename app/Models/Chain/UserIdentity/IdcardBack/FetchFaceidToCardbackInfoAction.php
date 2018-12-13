<?php

namespace App\Models\Chain\UserIdentity\IdcardBack;

use App\Models\Chain\AbstractHandler;
use App\Services\Core\Message\OCR\FaceService;

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
            $this->setSuccessor(new CreateIdCardUserOcrAction($this->params));
            return $this->getSuccessor()->handleRequest();
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
        if (isset($face_res['ERROR']) || $face_res['side'] != 1) {
            return false;
        }
        $this->params['request_id'] = $face_res['request_id'];
        $this->params['side'] = $face_res['side'];
        $this->params['completeness'] = $face_res['completeness'];
        $this->params['card_rect'] = json_encode($face_res['card_rect']);
        $this->params['legality'] = json_encode($face_res['legality']);
        $this->params['error'] = isset($face_res['ERROR']) ? $face_res['ERROR'] : '';
        $this->params['valid_date_start'] = $face_res['valid_date_start']['result'];
        $this->params['issued_by'] = $face_res['issued_by']['result'];
        $this->params['valid_date_end'] = $face_res['valid_date_end']['result'];

        return true;
    }
}
