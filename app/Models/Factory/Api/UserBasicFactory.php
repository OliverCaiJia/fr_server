<?php

namespace App\Models\Factory\Api;

use App\Helpers\Utils;
use App\Models\Orm\UserBasic;
use App\Models\Orm\UserInfo;

/**
 * 用户基础信息工厂类
 * Class UserBasicFactory
 * @package App\Models\Factory\Api
 */
class UserBasicFactory extends ApiFactory
{
    /**
     * 获取用户基础信息
     * @param $userId
     * @return array
     */
    public static function fetchUserBasic($userId)
    {
        $userRealname = UserBasic::select([
            'user_id',
            'user_location',
            'user_address',
            'profession',
            'company_name',
            'company_location',
            'company_address',
            'company_license_time',
            'work_time',
            'month_salary',
            'zhima_score',
            'house_fund_time',
            'has_creditcard',
            'has_social_security',
            'has_house',
            'has_auto',
            'has_house_fund',
            'has_assurance',
            'has_weilidai'])
            ->where(['user_id' => $userId])
            ->first();
        return $userRealname ? $userRealname->toArray() : [];
    }

    /**
     * 创建或更新用户基础信息
     * @param $data
     * @param array $uid
     * @return bool
     */
    public static function createOrUpdateUserBasic($data, $uid = [])
    {
        $userData = UserBasic::updateOrCreate(['user_id' => $uid], [
            'user_location' => $data['user_location'],
            'user_address' => $data['user_address'],
            'profession' => $data['profession'],
            'company_name' => $data['company_name'],
            'company_location' => $data['company_location']?? '',
            'company_address' => $data['company_address'],
            'company_license_time' => $data['company_license_time']?? 0,
            'work_time' => $data['work_time'] ?? 0,
            'month_salary' => $data['month_salary'] ?? 0,
            'zhima_score' => $data['zhima_score'],
            'house_fund_time' => $data['house_fund_time'] ?? 0,
            'has_social_security' => $data['has_social_security']?? 0,
            'has_house' => $data['has_house']?? 0,
            'has_auto' => $data['has_auto']?? 0,
            'has_house_fund' => $data['has_house_fund']?? 0,
            'has_creditcard' => $data['has_creditcard']?? 0,
            'has_assurance' => $data['has_assurance']?? 0,
            'has_weilidai' => $data['has_weilidai']?? 0,
            'create_at' => date('Y-m-d H:i:s', time()),
            'update_at' => date('Y-m-d H:i:s', time()),
        ]);
        return $userData->toArray();

    }

    public static function getUserBasicByUserId($userId)
    {
        $userOrder = UserBasic::select()
            ->where('user_id', '=', $userId)
            ->first();
        return $userOrder ? $userOrder->toArray() : [];
    }
}