<?php

namespace App\Services\Core\Message\Sms\Chuanglan;

use App\Services\AppService;
use App\Helpers\Http\HttpClient;
/**
 * 创蓝短信通道
 * Class ChuanglanService
 * @package App\Services\Core\Sms\Chuanglan
 */
class ChuanglanService extends AppService
{

    /**
     *
    $data = [
     *      'msg' => $msg,  //短信内容
     *      'phone' => $phone,   //手机号
     * ]
     */
    public static function send($data = [])
    {
        if (!empty($data))
        {
            $url = ChuanglanConfig::CHUANGLAN_API_URL;
            $account = ChuanglanConfig::CHUANGLAN_API_ACCOUNT;
            $password = ChuanglanConfig::CHUANGLAN_API_PASSWORD;

            $request = [
                'json' => [
                    'account' => $account,
                    'password' => $password,
                    'msg' => $data['msg'],
                    'phone' => $data['phone'],
                ]
            ];
            $promise = HttpClient::i()->request('POST', $url, $request);
            $result = $promise->getBody()->getContents();
            return $result;
        }

        return false;
    }
}
