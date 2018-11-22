<?php

namespace App\Services\Core\Message\OCR;

use App\Helpers\Http\HttpClient;
use App\Http\Controllers\Api\V1\UserIdentityController;
use App\Services\AppService;


class FaceService extends AppService
{
    public function fetchBackOrFront($data)
    {
        $appKey = 'i-EgIJJiMieGKRWTt55_T4I9xVIl8hmP';
        $appSecret = 'bYBRxiVg43eZQbKxMYkNnc6g-aZE-naT';
        $url = 'https://api.megvii.com/faceid/v3/ocridcard';

//        $imgUrl = '/home/zhijie/下载/600921248.jpg';
        $image = $data['imgUrl'];
//        $image = file_get_contents($imgUrl);
        //将字符串进行base64加密
//        $image = base64_encode($image);
        $request = [
            'multipart' => [
                [
                    'name' => 'image',
                    'contents' => fopen($image, 'r'),
                ],
                [
                    'name' => 'api_key',
                    'contents' => $appKey,
                ],
                [
                    'name' => 'api_secret',
                    'contents' => $appSecret,
                ],
                // 是否返回身份证照片合法性检查结果 “1”：返回； “0”：不返回。
                [
                    'name' => 'legality',
                    'contents' => 1,
                ],
            ],
        ];
        //请求face++
        $response = HttpClient::i()->request('POST', $url, $request);
        $result = $response->getBody()->getContents();
        $res = json_decode($result, true);
        return $res;
    }

    public function fetchFront($data)
    {
        $appKey = 'i-EgIJJiMieGKRWTt55_T4I9xVIl8hmP';
//        $appKey = ValidatorService::o()->getFaceidAppKey();
        $appSecret = 'bYBRxiVg43eZQbKxMYkNnc6g-aZE-naT';
//        $appSecret = ValidatorService::o()->getFaceidAppSecret();
//        $url = ValidatorService::o()::FACEID_API_URL . ValidatorService::o()::FACEID_API_URI;

        $url = 'https://api.megvii.com/faceid/v3/ocridcard';
//        $url = ValidatorService::FACEID_API_URL . '/faceid/v3/ocridcard';
//        $apiKey = ValidatorService::getFaceidAppKey();
//        $apiSecret = ValidatorService::getFaceidAppSecret();
//

        $image = '/home/zhijie/下载/600921248.jpg';
//        $image = file_get_contents($imgUrl);
        //将字符串进行base64加密
//        $image = base64_encode($image);
        $request = [
            'multipart' => [
                [
                    'name' => 'image',
                    'contents' => fopen($image, 'r'),
                ],
                [
                    'name' => 'api_key',
                    'contents' => $appKey,
                ],
                [
                    'name' => 'api_secret',
                    'contents' => $appSecret,
                ],
                // 是否返回身份证照片合法性检查结果 “1”：返回； “0”：不返回。
                [
                    'name' => 'legality',
                    'contents' => 1,
                ],
            ],
        ];
        //请求face++
        $response = HttpClient::i()->request('POST', $url, $request);
        $result = $response->getBody()->getContents();
        $res = json_decode($result, true);
        return $res;
    }
}