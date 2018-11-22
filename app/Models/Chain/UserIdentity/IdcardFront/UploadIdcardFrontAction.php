<?php

namespace App\Models\Chain\UserIdentity\IdcardFront;

use App\Models\Chain\AbstractHandler;
use OSS\Common;
use OSS\OssClient;
use App\Helpers\Utils;

/**
 * Class SendImageToQiniuAction
 * @package App\Models\Chain\UserIdentity\IdcardFront
 * 获取app端传的图片，并上到AliOSS
 */
class UploadIdcardFrontAction extends AbstractHandler
{
    private $params = array();
    protected $error = array('error' => '图片获取失败，请重试！', 'code' => 10001);

    public function __construct($params)
    {
        $this->params = $params;
    }

    /**
     * @return array
     * 1.获取app端传的图片，并上到AliOSS
     */
    public function handleRequest()
    {
        if ($this->uploadIdcardFront($this->params) == true) {
            $this->setSuccessor(new FetchFaceidToCardfrontInfoAction($this->params));
            return $this->getSuccessor()->handleRequest();
        } else {
            return $this->error;
        }
    }

    /**
     * @param $params
     * @return bool
     * 获取app端传的图片，并上到AliOSS,上传身份证正面照
     */
    private function uploadIdcardFront($params =[])
    {
        $imageFile = $params['card_file'];
        $bucketName = Common::getBucketName();
        $object = Utils::createObjectName() . "idcard.jpg";
        $ossClient = Common::getOssClient();
        if (is_null($ossClient)){
            return false;
        }

        // 先把本地的example.jpg上传到指定$bucket, 命名为$object
        $ossClient->uploadFile($bucketName, $object, $imageFile);

        //生成一个带签名的可用于浏览器直接打开的url, URL的有效期是3600秒
        $timeout = 3600;
        $options = array(
            OssClient::OSS_PROCESS => "image/resize,m_lfit,h_100,w_100",
        );
        $signedUrl = $ossClient->signUrl($bucketName, $object, $timeout, "GET", $options);
        if(!$signedUrl){
            return false;
        }
        $this->params['signedUrl'] = $signedUrl;
        return true;
    }

}
