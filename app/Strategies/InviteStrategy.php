<?php

namespace App\Strategies;

/**
 * @author zhaoqiying
 */
use App\Constants\CreditConstant;
use App\Helpers\Formater\NumberFormater;
use App\Helpers\RestUtils;
use App\Models\Factory\Api\InviteFactory;
use App\Strategies\AppStrategy;
use App\Models\Factory\Web\UserInviteFactory;

/**
 * 身份策略
 *
 * Class UserStrategy
 * @package App\Strategies
 */
class InviteStrategy extends AppStrategy
{
    /**
     * @return string
     * 邀请码
     */
    public static function createCode()
    {
        $code = date('y') . date('m') .  date('d') . UserStrategy::getRandChar(6, 'NC');
        return $code;
    }

    /**
     * @param $invite
     * @return mixed
     * 邀请好友
     */
    public static function toInviteSign($invite_num, $invite_code)
    {
        if ($invite_num >= 1 && $invite_num < 2) {
            $datas['firstSign']  = CreditConstant::SIGN_FULL;
            $datas['secondSign'] = CreditConstant::DEFAULT_EMPTY;
            $datas['thirdSign']  = CreditConstant::DEFAULT_EMPTY;
        } elseif ($invite_num >= 2 && $invite_num < 3) {
            $datas['firstSign']  = CreditConstant::SIGN_FULL;
            $datas['secondSign'] = CreditConstant::SIGN_FULL;
            $datas['thirdSign']  = CreditConstant::DEFAULT_EMPTY;
        } elseif ($invite_num >= 3) {
            $datas['firstSign']  = CreditConstant::SIGN_FULL;
            $datas['secondSign'] = CreditConstant::SIGN_FULL;
            $datas['thirdSign']  = CreditConstant::SIGN_FULL;
        } else {
            $datas['firstSign']  = CreditConstant::DEFAULT_EMPTY;
            $datas['secondSign'] = CreditConstant::DEFAULT_EMPTY;
            $datas['thirdSign']  = CreditConstant::DEFAULT_EMPTY;
        }
    }

    /**
     * 获取用户成功邀请列表
     * @param $userId
     * @return array
     */
    public static function getInvitedUsers($userId)
    {
        $inviteData = UserInviteFactory::getInvitedUsersByUserId($userId);
        $data = [];
        foreach($inviteData as $k=>$v){
            $status = UserInviteFactory::getUserOrderStatus($v['user_id']);
            if($status){
                array_push($data, $v);
            }
        }
        return $data;
    }

}
