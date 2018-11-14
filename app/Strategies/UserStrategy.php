<?php

namespace App\Strategies;

use App\Helpers\Formater\NumberFormater;
use App\Helpers\Utils;
use App\Services\Core\Store\Qiniu\QiniuService;
use App\Strategies\AppStrategy;
use App\Helpers\UserAgent;

/**
 * 用户公共策略
 *
 * Class UserStrategy
 * @package App\Strategies
 */
class UserStrategy extends AppStrategy
{

    /**
     * @desc 生成随机字符串
     * @param $length
     * @return null|string
     */
    public static function getRandChar($length, $format = 'ALL')
    {
        $str = null;
        //$strPol = "ABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789abcdefghijklmnopqrstuvwxyz";
        switch ($format) {
            case 'ALL':
                $strPol = 'ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789';
            case 'NC':
                $strPol = '0123456789abcdefghijklmnopqrstuvwxyz';
                break;
            case 'CHAR':
                $strPol = 'ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz';
                break;
            case 'NUMBER':
                $strPol = '0123456789' . time() . mt_rand(100, 1000000);
                break;
            default :
                $strPol = 'ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789';
                break;
        }
        $max = strlen($strPol) - 1;
        for ($i = 0; $i < $length; $i++) {
            $str .= $strPol[mt_rand(0, $max)]; //rand($min,$max)生成介于min和max两个数之间的一个随机整数
        }
        return $str;
    }
}
