<?php

namespace App\Strategies;

/**
 * @author zhaoqiying
 */
use App\Constants\CreditConstant;
use App\Helpers\RestUtils;
use App\Strategies\AppStrategy;
use App\Models\Orm\UserRealname;
use App\Models\Orm\UserBasic;
use App\Models\Orm\UserBankcard;
use App\Models\Orm\UserReport;

class UserAuthenticationStatusStrategy extends AppStrategy
{

    public static function assemble($uid)
    {
        $data = [];
        $data['Authentication'] = self::isUserAuthentication($uid);
        $data['Basic'] = self::isUserBasic($uid);
        $data['BankCrad'] = self::isUserBankCrad($uid);
        $data['report'] = self::isUserReport($uid);
        return $data ? $data : [];
    }

    /**判断用户是否实名认证
     * @param $uid
     * @return array
     */
    public static function isUserAuthentication($uid)
    {
        $userStatus = UserRealname::where(['user_id' => $uid])->get()->toArray();
        if (empty($userStatus)) {
            $status = '未完成';
        } else {
            $status = '完成';
        }
        return $status;
    }

    /**判断用户资料是否完成
     * @param $uid
     * @return string
     */
    public static function isUserBasic($uid)
    {
        $userStatus = UserBasic::where(['user_id' => $uid])->get()->toArray();
        if (empty($userStatus)) {
            $status = '未完成';
        } else {
            $status = '完成';
        }
        return $status;
    }

    /**判断用户是否绑定银行卡
     * @param $uid
     * @return string
     */
    public static function isUserBankCrad($uid)
    {
        $userStatus = UserBankcard::where(['user_id' => $uid])->get()->toArray();
        if (empty($userStatus)) {
            $status = '未完成';
        } else {
            $status = '完成';
        }
        return $status;
    }

    public static function isUserReport($uid)
    {
        $userStatus = UserReport::where(['user_id' => $uid])->get()->toArray();
        if (empty($userStatus)) {
            $status = '未完成';
        } else {
            $status = '完成';
        }
        return $status;
    }

}
