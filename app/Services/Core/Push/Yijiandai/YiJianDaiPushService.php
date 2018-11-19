<?php
namespace App\Services\Core\Push\Yijiandai;

use App\Helpers\Http\HttpClient;
use App\Services\AppService;

/**
 * Class PushService
 * @package App\Services\Core\Store\Push
 * 推送
 */
class YiJianDaiPushService extends AppService
{
    /**
     * 推送数据
     * @param array $params
     * @return string
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public static function sendPush($params = [])
    {
        //获取config
        $url = YiJianDaiPushConfig::YIJIANDAI_PUSH_URL;
        $key = YiJianDaiPushConfig::YIJIANDAI_KEY;
        $channel = YiJianDaiPushConfig::YIJIANDAI_CHANNEL;

        //获取参数加密字符串
        $bizData = self::getEncodeData($params, $key);

        //获取参数
        $form_data['channel_fr'] = $channel;
        $form_data['bizData'] = $bizData;

        //获取签名
        $sign = self::getSignInfo($form_data, $key);

        $form_data['sign'] = $sign;
        $data['form_params'] = $form_data;

        $response = HttpClient::i()->request('POST', $url, $data);
        $result = $response->getBody()->getContents();
        return $result;
    }

    /**
     * 获取推送结果
     * @param array $params
     * @return string
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public static function getPull($params = [])
    {
        //获取config
        $url = YiJianDaiPushConfig::YIJIANDAI_PULL_URL;
        $key = YiJianDaiPushConfig::YIJIANDAI_KEY;
        $channel = YiJianDaiPushConfig::YIJIANDAI_CHANNEL;

        //获取参数加密字符串
        $bizData = self::getEncodeData($params, $key);

        //获取参数
        $form_data['channel_fr'] = $channel;
        $form_data['bizData'] = $bizData;

        //获取签名
        $sign = self::getSignInfo($form_data, $key);

        $form_data['sign'] = $sign;
        $data['form_params'] = $form_data;

        $response = HttpClient::i()->request('POST', $url, $data);
        $result = $response->getBody()->getContents();
        return json_decode($result,true);
    }

    /**
     * 获取签名
     * @param array $params
     * @param $key
     * @return string
     */
    public static function getSignInfo($params = [],$key) {
        $srcStr = "";
        $names = array();
        foreach($params as $name => $value) {
            $names[$name] = $name;
        }
        sort($names);
        foreach($names as $name) {
            $srcStr = $srcStr.$name."=".$params[$name]."&";
        }

        $srcStr = substr($srcStr, 0, strlen($srcStr) - 1);

        return md5($srcStr.$key);
    }

    /**
     * 参数加密
     * @param array $params
     * @param $key
     * @return string
     */
    public static function getEncodeData($params = [] , $key)
    {
        //验证数组
        $string = json_encode($params);
        $iv = $password = substr(md5($key),0,16);//AES算法的密码password和初始变量iv
        $encrypted = openssl_encrypt($string, 'AES-128-CBC',$password,1,$iv);
        $en_result = base64_encode($encrypted); //bizData 密文数据
        return $en_result;
    }

    /**
     * 参数解密
     * @param array $params
     * @param $key
     * @return string
     */
    public function getDecodeData($en_result){
        $decrypted = base64_decode( $en_result);
        $iv = $password = substr(md5(self::KEY),0,16);//AES算法的密码password和初始变量iv
        $de_result = openssl_decrypt($decrypted, 'AES-128-CBC',$password,1,$iv);
        $de_string = json_decode($de_result,true);
        return $de_string;
    }

}