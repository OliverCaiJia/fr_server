<?php

namespace App\Models\Factory\Api;

use App\Helpers\Utils;
use App\Models\Orm\UserBasic;

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
            'profession',
            'company_name',
            'company_location',
            'company_address',
            'company_license_time',
            'work_time',
            'month_salary',
            'zhima_score',
            'house_fund_time',
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
    public static function createOrUpdateUserBasic($data,$uid = [])
    {
        $UserData = UserBasic::where(['user_id' => $uid])->first();
        //如果不为空说明表中没有用户的个人信息,创建
        if (!empty($UserData)) {
            $UserData->user_location = $data['user_location'];
            $UserData->user_address = $data['user_address'];
            $UserData->profession = $data['profession'];
            $UserData->company_name = $data['company_name'];
            $UserData->company_location = $data['company_location'];
            $UserData->company_address = $data['company_address'];
            $UserData->company_license_time = $data['company_license_time'];
            $UserData->work_time = $data['work_time'];
            $UserData->month_salary = $data['month_salary'];
            $UserData->zhima_score = $data['zhima_score'];
            $UserData->house_fund_time = $data['house_fund_time'];
            $UserData->has_social_security = $data['has_social_security'];
            $UserData->has_house = $data['has_house'];
            $UserData->has_auto = $data['has_auto'];
            $UserData->has_house_fund = $data['has_house_fund'];
            $UserData->has_assurance = $data['has_assurance'];
            $UserData->has_weilidai = $data['has_weilidai'];
            $UserData->update_at = date('Y-m-d H:i:s');
            return $UserData->save();
        } else {
            //如果为空,修改
            $UserBasic = new UserBasic();
            $UserBasic->user_id = $uid;
            $UserData->user_location = $data['user_location'];
            $UserData->user_address = $data['user_address'];
            $UserBasic->profession = $data['profession'];
            $UserBasic->company_name = $data['company_name'];
            $UserBasic->company_location = $data['company_location'];
            $UserBasic->company_address = $data['company_address'];
            $UserData->company_license_time = $data['company_license_time'];
            $UserBasic->work_time = $data['work_time'];
            $UserBasic->month_salary = $data['month_salary'];
            $UserBasic->zhima_score = $data['zhima_score'];
            $UserBasic->house_fund_time = $data['house_fund_time'];
            $UserBasic->has_social_security = $data['has_social_security'];
            $UserBasic->has_house = $data['has_house'];
            $UserBasic->has_auto = $data['has_auto'];
            $UserBasic->has_house_fund = $data['has_house_fund'];
            $UserBasic->has_assurance = $data['has_assurance'];
            $UserBasic->has_weilidai = $data['has_weilidai'];
            $UserBasic->create_at = date('Y-m-d H:i:s');
            $UserBasic->update_at = date('Y-m-d H:i:s');
            return $UserBasic->save();
        }

    }
}