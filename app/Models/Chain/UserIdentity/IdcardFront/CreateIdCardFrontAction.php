<?php

namespace App\Models\Chain\UserIdentity\IdcardFront;

use App\Models\Chain\AbstractHandler;

/**
 * Class SendImageToQiniuAction
 * @package App\Models\Chain\UserIdentity\IdcardFront
 *  图片存储
 */
class CreateIdCardFrontAction extends AbstractHandler
{
    private $params = array();
    protected $error = array('error' => '图片获取失败，请重试！', 'code' => 10001);

    public function __construct($params)
    {
        $this->params = $params;
    }

    /**
     * @return array
     * 写入图片流
     */
    public function handleRequest()
    {
        if ($this->createIdcardFront($this->params) == true) {
            $this->setSuccessor(new UploadIdcardFrontAction($this->params));
            return $this->getSuccessor()->handleRequest();
        } else {
            return $this->error;
        }
    }

    /**
     * @param $params
     * @return bool
     * 图片存储
     */
    private function createIdcardFront($params = [])
    {
        $file = $params['card_front'];
        if (!empty($file)) {
            if (!$file->isValid()) {
                return false;
            }

            $imgDir = base_path() . '/Uploads/';
            //要生成的图片名字
            $filename = md5(time() . mt_rand(10, 99)) . ".jpg"; //新图片名称
            $newFilePath = $imgDir . $filename;
            $file->move($imgDir, $filename);

            if (!file_exists($newFilePath)) {
                return false;
            }
            $this->params['card_file'] = $newFilePath;
        }
        return true;
    }

}
