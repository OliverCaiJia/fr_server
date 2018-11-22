<?php

namespace App\Models\Chain\UserIdentity\IdcardFront;

use App\Models\Chain\AbstractHandler;

/**
 * Class SendImageToQiniuAction
 * @package App\Models\Chain\UserIdentity\IdcardFront
 * 写入图片流
 */
class CreateIdcardFrontAction extends AbstractHandler
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
     * 写入图片流
     */
    private function createIdcardFront($params =[])
    {
        $imgDir = base_path().'/Uploads/';
        $file = $params['card_front'];
        //要生成的图片名字
        $filename = md5(time().mt_rand(10, 99)).".jpg"; //新图片名称
        $newFilePath = $imgDir.$filename;
        $newFile = fopen($newFilePath,"w+"); //打开文件准备写入
        fwrite($newFile,$file); //写入二进制流到文件
        fclose($newFile); //关闭文件
        if(!file_exists($newFilePath)){
            return false;
        }
        $this->params['card_file'] = $newFilePath;

        return true;
    }

}
