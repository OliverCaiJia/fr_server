<?php

namespace App\Models\Factory\Api;

use App\Helpers\Utils;
use App\Models\Orm\UserRealname;

/**
 * 用户实名信息工厂类
 * Class UserRealnameFactory
 * @package App\Models\Factory\Api
 */
class UserRealnameFactory extends ApiFactory
{
    /**
     * 获取用户实名信息
     * @param $userId
     * @return array
     */
    public static function fetchUserRealname($userId)
    {
        $userRealname = UserRealname::select(['real_name', 'id_card_type', 'id_card_no', 'id_card_front_img', 'id_card_back_img',
            'issued_by', 'valid_start_date', 'valid_end_date'])
            ->where(['user_id' => $userId])
            ->first();

        return $userRealname ? $userRealname->toArray() : [];
    }

    /**
     * 创建或更新用户实名信息
     * @param $data
     * @param $userId
     * @return bool
     */
    public static function createOrUpdateUserRealname($userId, $data)
    {
        $userRealname = UserRealname::where(['user_id' => $userId])->first();
        if (empty($userRealname)) {
            $userRealname = new UserRealname();
            //只创建一次不修改
            $userRealname->create_at = date('Y-m-d H:i:s', time());
            $userRealname->create_id = $userId;
            $userRealname->create_ip = Utils::ipAddress();
            $userRealname->outApplyNo = $userId . date('Ymd', time()) . time() . rand(1000, 9999);
        }
        $userRealname->user_id = $userId;
        $userRealname->real_name = $data['realName'];
        $userRealname->identity_card = $data['identityCard'];
        $userRealname->sex = $data['sex'];
        $userRealname->age = intval($data['age']);
        $userRealname->update_at = date('Y-m-d H:i:s', time());
        $userRealname->update_id = $userId;
        $userRealname->update_ip = Utils::ipAddress();
        return $userRealname->save();
    }
}