<?php

namespace App\Models\Factory\Api;

use App\Helpers\Utils;
use App\Models\Orm\UserInvite;
use App\Models\Orm\UserInviteLog;
use App\Models\Orm\UserInviteCode;
use App\Models\Orm\UserOrder;
use App\Strategies\InviteStrategy;

/**
 * Class InviteFactory
 * @package App\Models\Factory\Api
 * 好友邀请
 */
class InviteFactory extends ApiFactory
{
    /**
     * 获取邀请好友
     * @param $user_id
     * @return int
     */
    public static function fetchUserInvitations($user_id)
    {
        $invite = UserInvite::select(['user_id','mobile'])->where(['invite_user_id' => $user_id])->get()->toArray();
//        $inviteOrder = self::getInvitedUsersOrderStatus($invite);
        foreach ($invite as $key => $val) {
            $UserOrederStatus = UserOrder::select(['user_id','status'])->where(['user_id' => $val['user_id'], 'status' => 1])->first();
            if (!empty($UserOrederStatus)) {
                if ($UserOrederStatus->status == 1){
//                    $invites[$key]['user_status'] = $UserOrederStatus->status;
                    $invites[$key]['status'] = "付费";
                    $invites[$key]['money'] = "36";
                    $invites[$key]['mobile'] = $invite[$key]['mobile'];
                }
            }
        }
        return $invites ? $invites : [];
    }

    /**
     * @param $userId
     * @return array
     * 验证并生成邀请码
     */
    public static function fetchInviteCode($userId)
    {
        $inviteCode = UserInviteCode::firstOrCreate(['user_id' => $userId], [
            'user_id' => $userId,
            'code' => InviteStrategy::createCode(),
            'status' => 0,
            'create_id' => $userId,
            'expired_at' => '2116-01-01 00:00:00',
            'create_at' => date('Y-m-d H:i:s', time()),
            'create_ip' => Utils::ipAddress(),
            'update_at' => date('Y-m-d H:i:s', time()),
            'update_id' => $userId,
            'update_ip' => Utils::ipAddress(),
        ]);
        $now = date('Y-m-d H:i:s', time());
        if ($inviteCode->expired_at < $now) {
            $inviteCode->code = InviteStrategy::createCode();
            $inviteCode->expired_at = '2116-01-01 00:00:00';
            $inviteCode->updated_at = date('Y-m-d H:i:s', time());
            $inviteCode->updated_user_id = $userId;
            $inviteCode->updated_ip = Utils::ipAddress();
            $inviteCode->save();
        }
        return $inviteCode->code ? $inviteCode->code : '';
    }

    /**
     * @param $userId
     * @return array
     * 查询userId邀请码 object
     */
    public static function getInviteCode($userId)
    {
        $inviteCode = UserInviteCode::select(['code'])
            ->where(['user_id' => $userId])
            ->where('expired_at', '<=', date('Y-m-d H:i:s', time()))
            ->first();
        return $inviteCode ? $inviteCode->code : 0;
    }

    /**
     * @param $userId
     * @param $data
     * 短信邀请流水表查询
     */
    public static function fetchInviteLog($data)
    {
        $inviteLog = UserInviteLog::where(['mobile' => $data['mobile']])
            ->first();
        return $inviteLog ? $inviteLog->toArray() : [];
    }

    /**
     * 根据邀请码获得邀请人id
     * @param $code
     */
    public static function fetchInviteUserIdByCode($code)
    {
        $user_invite = UserInviteCode::select('user_id')->where('code', '=', $code)->first();
        return $user_invite ? $user_invite->user_id : '';
    }


    /**
     * 根据手机号和状态去邀请日志表中获得邀请人id
     * @param $code
     */
    public static function fetchInviteUserIdByMobileFromLog($mobile)
    {
        $user_invite_log = UserInviteLog::select('user_id', 'code')->where('mobile', '=', $mobile)->where('status', '=', 1)->orderBy('created_at', 'desc')->first();
        return $user_invite_log ? $user_invite_log->toArray() : [];
    }


    /**
     * 修改或者创建邀请日志记录表
     * @param $params
     * @return mixed
     */
    public static function updateOrCreateInviteLog($params)
    {
        $inviteObj = UserInviteLog::updateOrCreate(['mobile' => $params['mobile']], [
            'user_id' => intval($params['user_id']),
            'invite_user_id' => intval($params['invite_user_id']),
            'from' => $params['from'],
            'code' => $params['sd_invite_code'],
            'mobile' => $params['mobile'],
            'status' => $params['status'],
            'created_at' => date('Y-m-d H:i:s', time()),
            'created_user_id' => intval($params['user_id']),
            'created_ip' => Utils::ipAddress(),
        ]);
        $inviteObj->user_id = $params['user_id'];
        $inviteObj->invite_user_id = intval($params['invite_user_id']);
        $inviteObj->from = $params['from'];
        $inviteObj->code = $params['sd_invite_code'];
        $inviteObj->mobile = $params['mobile'];
        $inviteObj->status = $params['status'];
        $inviteObj->created_at = date('Y-m-d H:i:s', time());
        $inviteObj->created_user_id = intval($params['user_id']);
        $inviteObj->created_ip = Utils::ipAddress();
        return $inviteObj->save();
    }

    /**
     * 添加邀请流水表记录
     * @param $data
     * @return bool
     */
    public static function createInviteLog($invite)
    {
        #获取当前用户的用户id
        $user_id = $invite['userId'];
        #通过code码获取邀请人的id
        $invite_user_id = $invite['invite_user_id'];
        #判断如果邀请吗不存在，使用外层传过来的user_id
        $inviteObj = new UserInviteLog();
        $inviteObj->user_id = $user_id;
        $inviteObj->invite_user_id = intval($invite_user_id);
        $inviteObj->from = $invite['from'];
        $inviteObj->code = $invite['sd_invite_code'];
        $inviteObj->mobile = $invite['mobile'];
        $inviteObj->status = $invite['status'];
        $inviteObj->created_at = date('Y-m-d H:i:s', time());
        $inviteObj->created_user_id = $user_id;
        $inviteObj->created_ip = Utils::ipAddress();
        return $inviteObj->save();
    }


    /**
     *更新用户邀请表
     * @param $data
     * @return mixed
     */
    public static function updateInvite($params)
    {
        $inviteObj = UserInvite::firstOrCreate(['user_id' => $params['user_id']], [
            'user_id' => intval($params['user_id']),
            'invite_num' => 1,
            'update_ip' => Utils::ipAddress(),
        ]);
        $inviteObj->increment('invite_num', 1);
        return $inviteObj->save();
    }

    /**
     * 邀请好友获得积分规则
     * @param $user_id
     * @return int
     */
    public static function inviteScore($user_id)
    {
        $invite = UserInvite::where('user_id', '=', $user_id)->first();
        if ($invite->invite_num == 2) {
            $score = 300;
        } elseif ($invite->invite_num == 3) {
            $score = 450;
        } elseif ($invite->invite_num > 3) {
            $score = 0;
        } else {
            $score = 250;
        }
        return $score ? $score : 0;
    }

    public static function updateInviteLogStatus($mobile, $user_id)
    {
        return UserInviteLog::where('mobile', '=', $mobile)->update(['status' => 2, 'invite_user_id' => $user_id]);
    }
}
