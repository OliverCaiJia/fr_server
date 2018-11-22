<?php

namespace App\Services\Core\Message\OCR;

use App\Helpers\Http\HttpClient;
use App\Services\AppService;


class FaceService extends AppService
{
    public function fetchBackOrFront($data)
    {
        $appKey = 'i-EgIJJiMieGKRWTt55_T4I9xVIl8hmP';
        $appSecret = 'bYBRxiVg43eZQbKxMYkNnc6g-aZE-naT';
        $url = 'https://api.megvii.com/faceid/v3/ocridcard';
        $image = $data['imgUrl'];
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