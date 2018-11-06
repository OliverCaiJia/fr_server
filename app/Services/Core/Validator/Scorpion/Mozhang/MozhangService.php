<?php
namespace App\Services\Core\Validator\Scorpion\Mozhang;

use App\Services\AppService;
use App\Helpers\Http\HttpClient;

class MozhangService extends AppService
{

    public static function getMoZhangContent( $name ,$idcard , $mobile, $num ,$qq_number=null)
    {
        //获取配置信息
        $app_id = MozhangConfig::getScorpioAppId();
        $method = MozhangConfig::SCORPIO_METHOD[$num];
        $format = MozhangConfig::getScorpioFormat();
        $sign_type = MozhangConfig::getScorpioSignType();
        $version = MozhangConfig::getScorpioVersion();
        $timestamp = self::getMillionSeconds();

        //content
        $biz_content = '{"name":"'.$name.'","idcard":"'.$idcard.'","mobile":"'.$mobile.'"}';
        $biz_content = $qq_number ? '{"name":"'.$name.'","idcard":"'.$idcard.'","mobile":"'.$mobile.'","qq":"'.$qq_number.'"}' : $biz_content;

        //签名字符串
        $paramsStr = "app_id={$app_id}&biz_content={$biz_content}&format={$format}&method={$method}&sign_type={$sign_type}&timestamp={$timestamp}&version={$version}";

        //rsa私钥字符串
        $secret = MozhangConfig::getScorpioSecret();

        //获取签名
        $sign = self::getSign($paramsStr,$secret);

        //请求url
        $url = MozhangConfig::SCORPIO_URL.'/risk-gateway/api/gateway?'.$paramsStr."&sign=".$sign;

        $response = HttpClient::i()->request('POST', $url);
        $result = $response->getBody()->getContents();
        $res = json_decode($result, true);
        return $res;
    }

    /**
     * 获取SHA1签名
     */
    public static function getSign($paramsStr,$secret)
    {
        $signature = "";
        $str = chunk_split( $secret, 64, "\n" );
        $key = "-----BEGIN RSA PRIVATE KEY-----\n$str-----END RSA PRIVATE KEY-----\n";
        openssl_sign( $paramsStr  ,$signature ,$key  );

        return base64_encode($signature);
    }

    /**
     * 获取毫秒级时间戳
     * @return number
     */
    protected static function getMillionSeconds()
    {
        list($msec, $sec) = explode(' ', microtime());
        $msectime =  (float)sprintf('%.0f', (floatval($msec) + floatval($sec)) * 1000);

        return $msectime ;
    }

}
