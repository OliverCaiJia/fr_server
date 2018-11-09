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
     * @param $userId
     * @return bool
     */
    public static function createOrUpdateUserBasic($userId, $data)
    {
        $userBasic = UserBasic::where(['user_id' => $userId])->first();
        if (empty($userBasic)) {
            $userBasic = new UserBasic();
            //只创建一次不修改
            $userBasic->create_at = date('Y-m-d H:i:s', time());
            $userBasic->create_id = $userId;
            $userBasic->create_ip = Utils::ipAddress();
            $userBasic->outApplyNo = $userId . date('Ymd', time()) . time() . rand(1000, 9999);
        }
        $userBasic->user_id = $userId;
        $userBasic->real_name = $data['realName'];
        $userBasic->identity_card = $data['identityCard'];
        $userBasic->sex = $data['sex'];
        $userBasic->age = intval($data['age']);
        $userBasic->update_at = date('Y-m-d H:i:s', time());
        $userBasic->update_id = $userId;
        $userBasic->update_ip = Utils::ipAddress();
        return $userBasic->save();
    }
}