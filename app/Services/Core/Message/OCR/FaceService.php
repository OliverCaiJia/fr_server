<?php

namespace App\Services\Core\Message\OCR;

use App\Helpers\Http\HttpClient;
use App\Helpers\Logger\SLogger;
use App\Services\AppService;


class FaceService extends AppService
{
    public function fetchBackOrFront($data)
    {
        $appKey = FaceConfig::APPKEY;
        $appSecret = FaceConfig::APPSECRET;
        $url = FaceConfig::getUrl();
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
        $res = [];
        try
        {
            $response = HttpClient::i()->request('POST', $url, $request);
        }
        catch (\Exception $e)
        {
            $res['ERROR'] = 1;
            return $res;
        }
        $result = $response->getBody()->getContents();
        $res = json_decode($result, true);
        return $res;
    }
}