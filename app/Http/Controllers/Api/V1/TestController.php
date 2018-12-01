<?php
namespace App\Http\Controllers\Api\V1;

use App\Helpers\Http\HttpClient;
use App\Http\Controllers\Api\ApiController;
use App\Models\Chain\Order\NoPayOrder\LoanOrder\DoApplyOrderHandler;
use App\Models\Chain\Order\NoPayOrder\ProductOrder\DoProductOrderHandler;
use App\Models\Chain\Order\PayOrder\PaidOrder\DoPaidOrderHandler;
use App\Services\Core\Validator\Scorpion\Mozhang\MozhangService;
use App\Services\Core\Validator\ValidatorService;
use App\Services\Core\Payment\YiBao\YiBaoService;
use App\Services\Core\Push\Yijiandai\YiJianDaiPushService;
use Illuminate\Http\Request;

class TestController extends ApiController
{
    //易宝支付
    public function test(){
        $data = [
            'orderId' => 'DS181126_11511192',
            'orderAmount' => '0.01',
            'goodsParamExt' => '{"goodsName":"水果贷测试","goodsDesc":"水果贷订单"}',
            'paymentParamExt' => '{"bankCardNo":"6212260200101725345","idCardNo":"610303197911112419","cardName":"巨琨"}',
            'userNo' => '15210029967',
        ];
//        $data = MozhangService::o()->getMoZhangContent('陈龙','142201199606297437','15210029967','application');
//        dd($data);die;
//        $data = [
//            'mobile' => '15210029967',
//            'name' => '陈龙',
//            'certificate_no' => '142201197007047437',
//            'sex' => '1',
//            'birthday' => '19950405',
//            'has_insurance' => '1',
//            'house_info' => '001',
//            'car_info' => '001',
//            'occupation' => '001',
//            'salary_extend' => '001',
//            'salary' => '105',
//            'accumulation_fund' => '001',
//            'work_hours' => '001',
//            'business_licence' => '001',
//            'has_creditcard' => '1',
//            'social_security' => '1',
//            'is_micro' => '1',
//            'city' => '北京市',
//            'money' => '100000',
//        ];
//        $data = [
//            'mobile' => '15210029967'
//        ];
//        $data = YiJianDaiPushService::o()->getPull($data);
//        print_r($data);die;


            $data['goodsParamExt'] = '{"goodsName":"商品称","goodsDesc":"商品述"}';
           $data['orderAmount'] = 1;
           $data['orderId'] = 'SGD-A-20181119220807-170';
           $data['paymentParamExt'] = '{"bankCardNo":"6212260200036506778","idCardNo":"130702198111071511","cardName":"蔡嘉"}';
           $data['userNo'] = '18510536684';
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


    public function tradeOrder() {
//        $order = [];
//        $order['order_no'] = 'SGD-A-20181117213040-256937';
//        $chain = new DoPaidOrderHandler($order);
//        $result = $chain->handleRequest();
//        dd($result);
    }

    public function product() {
        //todo::多个赠送服务订单
        $order = [];
        $order['order_no'] = 'SGD-A-20181117213040-256937';
        $order['amount'] = 0;
        $order['count'] = 1;
        $chain = new DoProductOrderHandler($order);
        $result = $chain->handleRequest();
        dd($result);


    }

    public function doApply(Request $request) {
        $order = [];
        $order['order_no'] = 'SGD-R-20181201154025-311957';
        $order['report_type_nid'] = 'report_credit';
//        $order['money'] = '666';

//        $userOrderObj = new UserOrder();
//        $userOrderObj->user_id = $params['user_id'];
//        $userOrderObj->order_no = $params['order_no'];
//        $userOrderObj->order_type = $params['order_type'];
//        $userOrderObj->p_order_id = $params['p_order_id'];
//        $userOrderObj->order_expired = $params['order_expired'];//读配置
//        $userOrderObj->amount = $params['amount'];
//        $userOrderObj->term = $params['term'];
//        $userOrderObj->count = $params['count'];
//        $userOrderObj->status = $params['status'];
//        $userOrderObj->create_ip = $params['create_ip'];
//        $userOrderObj->create_at = $params['create_at'];
//        $userOrderObj->update_ip = $params['update_ip'];
//        $userOrderObj->update_at = $params['update_at'];





//        $order['user_id'] = $this->getUserId($request);
//        $order['order_type_nid'] = $request->input('order_type_nid');
//        $order['pid'] = $request->input('pid');
//        $order['money'] = $request->input('money');
        $chain = new DoApplyOrderHandler($order);
        $result = $chain->handleRequest();
        dd($result);


//        $apply = MozhangService::o()->getMoZhangContent('蔡嘉', '130702198111071511','18510536684', 'application', '');
//
//        dd($apply);

    }
}