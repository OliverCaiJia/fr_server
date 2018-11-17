<?php
namespace App\Http\Controllers\Api\V1;

use App\Helpers\Http\HttpClient;
use App\Http\Controllers\Api\ApiController;
use App\Models\Chain\Order\PayOrder\PaidOrder\DoPaidOrderHandler;
use App\Services\Core\Validator\ValidatorService;
use App\Services\Core\Payment\YiBao\YiBaoService;

class TestController extends ApiController
{
    //易宝支付
    public function test(){
        $data = [
            'orderId' => 'DS181116_15341265',
            'orderAmount' => '0.01',
            'goodsParamExt' => '{"goodsName":"水果贷测试","goodsDesc":"水果贷订单"}',
            'paymentParamExt' => '{"bankCardNo":"6212260200101725345","idCardNo":"610303197911112419","cardName":"巨琨"}',
            'userNo' => '13520973931',
        ];
       $url = YiBaoService::send($data);
       echo $url;
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
        $order = [];
        $order['order_no'] = 'SGD-A-20181117213040-256937';
        $chain = new DoPaidOrderHandler($order);
        $result = $chain->handleRequest();
        dd($result);
    }



}