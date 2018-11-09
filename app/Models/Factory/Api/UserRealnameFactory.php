<?php

namespace App\Models\Factory;

use App\Helpers\Utils;
use App\Models\Factory\Api\ApiFactory;
use App\Models\Orm\UserAlipay;
use App\Models\Orm\UserBanks;
use App\Models\Orm\UserIdentity;
use App\Models\Orm\UserProfile;
use App\Models\Orm\UserRealname;
use App\Strategies\BankStrategy;
use App\Strategies\UserCertifyStrategy;
use App\Strategies\SexStrategy;
use App\Strategies\UserIdentityStrategy;
use App\Strategies\UserinfoStrategy;
use App\Strategies\UserProfileStrategy;

/**
 * Class UserinfoFactory
 * @package App\Models\Factory
 * 用户实名信息工厂类
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
        $profileObj = UserRealname::select(['real_name', 'id_card_type', 'id_card_no', 'id_card_front_img', 'id_card_back_img',
            'issued_by', 'valid_start_date', 'valid_end_date'])
            ->where(['user_id' => $userId])
            ->first();

        return $profileObj ? $profileObj->toArray() : [];
    }

    /**
     * 创建或更新用户实名信息
     * @param $data
     * @param $userId
     * @return bool
     */
    public static function createOrUpdateUserRealname($userId, $data)
    {
        $profileObj = UserRealname::where(['user_id' => $userId])->first();
        if (empty($profileObj)) {
            $profileObj = new UserRealname();
            //只创建一次不修改
            $profileObj->create_at = date('Y-m-d H:i:s', time());
            $profileObj->create_id = $userId;
            $profileObj->create_ip = Utils::ipAddress();
            $profileObj->outApplyNo = $userId . date('Ymd', time()) . time() . rand(1000, 9999);
        }
        $profileObj->user_id = $userId;
        $profileObj->real_name = $data['realName'];
        $profileObj->identity_card = $data['identityCard'];
        $profileObj->sex = $data['sex'];
        $profileObj->age = intval($data['age']);
        $profileObj->update_at = date('Y-m-d H:i:s', time());
        $profileObj->update_id = $userId;
        $profileObj->update_ip = Utils::ipAddress();
        return $profileObj->save();
    }
}