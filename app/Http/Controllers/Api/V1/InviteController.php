<?php

namespace App\Http\Controllers\Api\V1;

use App\Helpers\LinkUtils;
use App\Helpers\Logger\SLogger;
use App\Helpers\RestResponseFactory;
use App\Helpers\RestUtils;
use App\Http\Controllers\Controller;
use App\Models\Factory\Api\InviteFactory;
use App\Models\Orm\SystemConfig;
use App\Strategies\InviteStrategy;
use App\Strategies\SmsStrategy;
use Illuminate\Http\Request;
use App\Models\Factory\Api\UserAuthFactory;
use SimpleSoftwareIO\QrCode\Facades\QrCode;

/**
 * Class InviteController
 * @package App\Http\Controllers\V1
 * 邀请
 */
class InviteController extends Controller
{
    /**
     * @param Request $request
     * 用户邀请信息
     */
    public function link(Request $request)
    {
        $token = $this->getToken($request);
        //通过token获取uid
        $userId = UserAuthFactory::getUserByToken($token);
        //用户名
        $inviteArr['username'] = UserAuthFactory::fetchUserName($userId['id']);
        //分享链接
        $inviteCode = InviteFactory::fetchInviteCode($userId['id']);
        $inviteArr['share_link'] = LinkUtils::shareLanding($inviteCode);
        //短信内容
        $inviteArr['sms_content'] = SmsStrategy::getSmsContent($inviteArr['share_link']);
        return RestResponseFactory::ok($inviteArr);
    }

    /**
     * @return mixed
     * 生成二维码
     */
    public function sqcode(Request $request)
    {
        $token = $this->getToken($request);
        //通过token获取uid
        $userId = UserAuthFactory::getUserByToken($token);
        $sizeArr = $request->all();
        //邀请码
        $inviteCode = InviteFactory::fetchInviteCode($userId['id']);
        //扫码链接
        $landig = LinkUtils::shareLanding($inviteCode);
        $QrCode = QrCode::size($sizeArr['size'])->generate($landig);
        print_r($QrCode);die;
    }

}