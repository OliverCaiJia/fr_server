<?php
namespace App\Services\Core\Message\Sms\Chuanglan;

class ChuanglanConfig
{
    const CHUANGLAN_API_URL = PRODUCTION_ENV ? 'https://smssh1.253.com/msg/send/json': 'https://smssh1.253.com/msg/send/json';//创蓝api接口地址
    const CHUANGLAN_API_ACCOUNT = PRODUCTION_ENV ? 'N6653401': 'N6653401';//创蓝api账号
    const CHUANGLAN_API_PASSWORD = PRODUCTION_ENV ? 'OpldWYPvLaaf6a': 'OpldWYPvLaaf6a';//创蓝api密码

}
