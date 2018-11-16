<?php

namespace App\Models\Factory\Web;

use App\Models\Orm\UserInvite;
use App\Models\Orm\UserOrder;

class UserInviteFactory extends WebFactory
{
    /**
     * 获取邀请人记录表数据
     * @param $userId
     * @return array
     */
    public static function getInvitedUsersByUserId($userId)
    {
        $invite = UserInvite::select('user_id','mobile')->where('invite_user_id', '=', $userId)->get();
        return $invite ? $invite->toArray() : [];
    }

    /**
     * 获取用户是否成功下单
     * @param $userId
     * @return array
     */
    public static function getUserOrderStatus($userId)
    {
        $userOrderStatus = UserOrder::where(['user_id' => $userId, 'status' => 1])->first();
        return $userOrderStatus ? true : false;
    }
}
