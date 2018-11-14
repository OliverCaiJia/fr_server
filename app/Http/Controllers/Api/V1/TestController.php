<?php
namespace App\Http\Controllers\Api\V1;

use App\Helpers\Http\HttpClient;
use App\Http\Controllers\Api\ApiController;
use App\Services\Core\Validator\ValidatorService;

class TestController extends ApiController
{
    //易宝支付
    public function test(){

        echo 'aaa';exit;
    }

    //face++
    public function getFace() {//$image
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

    //yop 下单接口
    public function tradeOrder() {
        $url = 'https://open.yeepay.com/yop-center';
        $uri = '/rest/v1.0/std/trade/order';
        $merchantNo="10000466938";
        $parentMerchantNo="10000466938";
        $urlRequest = $url . $uri;
        $orderId = 'merchant12345';
        $orderAmount = 88.88;
        $notifyUrl = 'http://payment.merchant.com:8080/uc/payCallback?u8ChannelID=8';
        $goodsParamExt = '';
        $ledgerNo = '';
        $amount = '';
        $ledgerNo = '';
        $proportion = '';
    }
}