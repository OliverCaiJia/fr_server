<?php

namespace App\Models\Factory\Api;

use App\Helpers\Utils;
use App\Models\Orm\UserInvite;
use App\Models\Orm\UserInviteConfig;
use App\Models\Orm\UserInviteLog;
use App\Models\Orm\UserInviteCode;
use App\Models\Orm\UserOrder;
use App\Strategies\InviteStrategy;

/**
 * Class InviteFactory
 * @package App\Models\Factory\Api
 * 好友邀请
 */
class InviteConfigFactory extends ApiFactory
{
    /**
     * 获取邀请好友
     * @param $user_id
     * @return int
     */
    public static function getInviteContent()
    {
        $invite = UserInviteConfig::where(['status' => 0])->first();

        return $invite ? $invite->toArray() : [];
    }
}
