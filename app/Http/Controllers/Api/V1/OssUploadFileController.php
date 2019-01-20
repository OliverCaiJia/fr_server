<?php

namespace App\Http\Controllers\Api\V1;

use App\Helpers\Utils;
use App\Http\Controllers\Api\ApiController;
use Illuminate\Http\Request;
use OSS\Common;
use OSS\OssClient;
use OSS\Core\OssException;

class OssUploadFileController extends ApiController
{
    public function uploadImage(Request $request)
    {
        $imageFile = $request->input('image');
//        dd(__DIR__);///data/website/fr-server/app/Http/Controllers/Api/V1

//        vendor/aliyuncs/oss-sdk-php/ccc.jpg
//        dd($imageFile);
        $bucketName = Common::getBucketName();
        $object = Utils::createObjectName() . "idcard.jpg";
        $ossClient = Common::getOssClient();
//        $download_file = Utils::createObjectName() . "download.jpg";
        //todo::
        if (is_null($ossClient)) exit(666);
echo $object;exit;
//*******************************简单使用***************************************************************

// 先把本地的example.jpg上传到指定$bucket, 命名为$object
        $ossClient->uploadFile($bucketName, $object, __DIR__ . '/' . $imageFile);


        /**
         *  生成一个带签名的可用于浏览器直接打开的url, URL的有效期是3600秒
         */
        $timeout = 3600;
        $options = array(
            OssClient::OSS_PROCESS => "image/resize,m_lfit,h_100,w_100",
        );
        $signedUrl = $ossClient->signUrl($bucketName, $object, $timeout, "GET", $options);
        Common::println("rtmp url: \n" . $signedUrl);

//最后删除上传的$object
       // $ossClient->deleteObject($bucketName, $object);
    }
}