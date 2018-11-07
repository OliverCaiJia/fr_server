<?php
namespace App\Services\Core\Validator\TianChuang;

use App\Services\AppService;
use App\Helpers\Http\HttpClient;

/**
 * 天创
 *
 * Class TianChuangService
 * @package App\Services\Core\Credit\TianChuang
 */
class TianChuangService extends AppService
{

    /**
     * 银行卡号、姓名、身份证号、手机号四要素认证
     *
     * @param array $data
     * $data = [
     *      'bankcard' => $bankcard,  //银行卡号
     *      'name' => $name,   //姓名
     *      'idcard' => $idcard,   //身份证号
     *      'mobile' => $mobile,  //银行预留手机号码
     * ]
     * @return mixed
     */
    public static function authFourthElements($data = [])
    {
        if(!empty($data)){
            $url = TianChuangConfig::TIANCHUANG_API_FOUR_URL;
            $appid = TianChuangConfig::TIANCHUANG_APPID;
            $tokenid = TianChuangConfig::CHUANGLAN_TOKENID;
            $tokenKey = self::getTokenKey($url, $tokenid, $data);

            $request = [
                'form_params' => [
                    'appId' => $appid,
                    'tokenKey' => $tokenKey,
                    'bankcard' => $data['bankcard'],
                    'name' => $data['name'],
                    'idcard' => $data['idcard'],
                    'mobile' => $data['mobile']
                ]
            ];
            $response = HttpClient::i()->request('POST', $url, $request);
            $result = $response->getBody()->getContents();

            return $result;
        }

        return false;

    }

    /**
     * 身份认证
     *
    $data = [
     *      'name' => $name,   //姓名
     *      'idcard' => $idcard,   //身份证号
     * ]
     * @return mixed
     */
    public static function authPersonalIdCard($data = [])
    {
        if(!empty($data)){
            $url = TianChuangConfig::TIANCHUANG_API_TWO_URL;
            $appid = TianChuangConfig::TIANCHUANG_APPID;
            $tokenid = TianChuangConfig::CHUANGLAN_TOKENID;
            $tokenKey = self::getTokenKey($url, $tokenid, $data);

            $request = [
                'form_params' => [
                    'appId' => $appid,
                    'tokenKey' => $tokenKey,
                    'name' => $data['name'],
                    'idcard' => $data['idcard'],
                ]
            ];
            $response = HttpClient::i()->request('POST', $url, $request);
            $result = $response->getBody()->getContents();

            return $result;
        }

        return false;
    }

    /**
     * 生成tokenKey
     *
     * @param string $url
     * @param string $tokenid
     * @param $params
     * @return string
     */
    public static function getTokenKey($url = '', $tokenid = '', $params)
    {
        ksort($params);
        $paramStr = '';
        foreach ($params as $key => $param)
        {
            $paramStr .= $key . '=' . $param . ',';
        }

        $paramStr = rtrim($paramStr, ",");

        $tokenKey = md5($url . $tokenid . $paramStr);

        return $tokenKey;
    }

}
