<?php

namespace App\Services\Core\Payment\YiBao;
use App\Services\AppService;

class YiBaoService extends AppService
{

    public static function getString($response)
    {

        $str = "";

        foreach ($response as $key => $value) {
            $str .= $key . "=" . $value . "&";
        }
        $getSign = substr($str, 0, strlen($str) - 1);
        return $getSign;
    }

   public static function getUrl($response, $private_key)
    {
        $content = self::getString($response);
        $sign = self::signRsa($content, $private_key);
        $url = $content . "&sign=" . $sign;
        return $url;
    }

   public static function object_array($array)
    {
        if (is_object($array)) {
            $array = (array)$array;
        }
        if (is_array($array)) {
            foreach ($array as $key => $value) {
                $array[$key] = self::object_array($value);
            }
        }
        return $array;
    }

    public static function send($data = []){

        $merchantNo = YiBaoConfig::MERCHANTNO;
        $parentMerchantNo = YiBaoConfig::PARENTMERCHANTNO;
        $private_key = YiBaoConfig::PRIVATE_KEY;
        $yop_public_key = YiBaoConfig::YOP_PUBLIC_KEY;
        $serverroot = YiBaoConfig::SERVERROOT;
        $notifyUrl = YiBaoConfig::NOTIFYURL;

        $yp_request = new YopRequest("OPR:$merchantNo", $private_key, $serverroot, $yop_public_key);
        $yp_request->addParam("parentMerchantNo", $parentMerchantNo);
        $yp_request->addParam("merchantNo", $merchantNo);
        $yp_request->addParam("orderId", $data['orderId']); //订单编号
        $yp_request->addParam("orderAmount", $data['orderAmount']); //订单金额
        $yp_request->addParam("requestDate", date('Y-m-d H:i:s'));
        $yp_request->addParam("notifyUrl", 'http://10.151.31.134/demo/yop-ds/callback.php'); //回调地址
        $yp_request->addParam("goodsParamExt", '{"goodsName":"水果贷测试","goodsDesc":"水果贷订单"}'); //商品信息{"goodsName":"名称","goodsDesc":"描述"}
        $yp_request->addParam("paymentParamExt", '{"bankCardNo":"6212260200101725345","idCardNo":"610303197911112419","cardName":"巨琨"}'); //扩展参数 {"bankCardNo":"银行卡号","idCardNo":"身份证号","cardName":"姓名"}
        $yp_request->addParam("fundProcessType", 'REAL_TIME'); //资金处理类型


        $response = YopClient3::post("/rest/v1.0/std/trade/order", $yp_request);

        if ($response->validSign == 1) {
            echo "返回结果签名验证成功!\n";
        }
        //取得返回结果

        $data = self::object_array($response);

        $token = $data['result']['token'];
        $cashter = array(
            "merchantNo" => $merchantNo,
            "token" => $token,
            "timestamp" => time(), //时间戳
            "directPayType" => 'YJZF', //直连参数
            "cardType" => 'DEBIT', //卡种
            "userNo" => $data['userNo'], //用户唯一标识（手机号）
            "userType" => 'PHONE', //用户表示类型(PHONE)
        );

        $getUrl = self::getUrl($cashter, $private_key);
        $getUrl = str_replace("&timestamp", "&amp;timestamp", $getUrl);
        $url = "https://cash.yeepay.com/cashier/std?" . $getUrl;

        return $url;

    }

    public static function signRsa($source,$private_Key){
        $private_key = "-----BEGIN RSA PRIVATE KEY-----\n" .
            wordwrap($private_Key, 64, "\n", true) .
            "\n-----END RSA PRIVATE KEY-----";

        extension_loaded('openssl') or die('php需要openssl扩展支持');


        /* 提取私钥 */
        $privateKey = openssl_get_privatekey($private_key);

        ($privateKey) or die('密钥不可用');

        openssl_sign($source, $encode_data, $privateKey, "SHA256");

        openssl_free_key($privateKey);

        $signToBase64 = Base64Url::encode($encode_data);


        $signToBase64 .= '$SHA256';


        return $signToBase64;

    }

}