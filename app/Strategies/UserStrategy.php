<?php

namespace App\Strategies;

use Ionepub\Idcard;
use Shitoudev\Phone\PhoneLocation;

class UserStrategy extends AppStrategy
{
    /**
     * 通过身份证号码获取地区，年龄等信息
     *
     * @param $idCard
     *
     * @return array
     */
    public static function getUserInfoByIdCard($idCard)
    {
        $info = Idcard::getInstance($idCard);

        if (!$info->getAge()) {
            return false;
        }

        $region = explode(',', $info->getRegion(','));

        return [
            'age' => $info->getAge() ?? '',
            'gender' => $info->getGender() ?? '',
            'constellation' => UserStrategy::getConstellationByBirthday($info->getBirthday()),
            'province' => $region['0'] ?? '',
            'city' => $region['1'] ?? '',
            'region' => $region['2'] ?? '',
            'native_place' => implode('', $region),
        ];
    }

    /**
     * 通过身份证号码获取地址信息
     *
     * @param $idCard
     *
     * @return mixed
     */
    public static function getLocationByIdCard($idCard)
    {
        return Idcard::getInstance($idCard)->getRegion(',');
    }

    /**
     * 通过手机号获取归属地和运营商
     *
     * @param $phone
     *
     * @return array
     */
    public static function getPhoneInfoByPhone($phone)
    {
        $phoneLocation = new PhoneLocation();
        $info = $phoneLocation->find($phone);
        if (!isset($info['province'])) {
            return [];
        }

        return [
            'phone_attribution' => $info['province'] . $info['city'],
            'source_name_zh' => $info['province'] . $info['sp']
        ];
    }

    /**
     * 通过生日获取星座信息
     *
     * @param string $birthday 1999-01-01
     *
     * @return string
     */
    public static function getConstellationByBirthday($birthday)
    {
        $birthday = explode('-', $birthday);
        $birth_month = $birthday[1];
        $birth_date = $birthday[2];

        $constellation_name = array(
            '水瓶座', '双鱼座', '白羊座', '金牛座', '双子座', '巨蟹座',
            '狮子座', '处女座', '天秤座', '天蝎座', '射手座', '摩羯座'
        );

        if ($birth_date <= 22) {
            if ('1' != $birth_month) {
                $constellation = $constellation_name[$birth_month - 2];
            } else {
                $constellation = $constellation_name[11];
            }
        } else {
            $constellation = $constellation_name[$birth_month - 1];
        }

        return $constellation;
    }
}
