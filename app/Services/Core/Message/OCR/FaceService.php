<?php

namespace App\Services\Core\Message\OCR;

use App\Http\Controllers\Api\V1\UserIdentityController;
use App\Services\AppService;

/**
 * facd++服务
 * Class FaceService
 * @package App\Services\Core\Message\OCR
 */
class FaceService extends AppService
{
    /**
     * 获取身份证背面信息
     * @param $data
     * @return \Illuminate\Http\JsonResponse
     */
    public function fetchBack($data)
    {
        $useridentity = new UserIdentityController();
        $res = $useridentity->fetchFaceidToCardbackInfo($data);
        return $res;
    }

    /**
     * 获取身份证正面信息
     * @param $data
     * @return \Illuminate\Http\JsonResponse
     */
    public function fetchFront($data)
    {
        $useridentity = new UserIdentityController();
        $res = $useridentity->fetchFaceidToCardfrontInfo($data);
        return $res;
    }
}