<?php

namespace App\Http\Controllers\Api\V1;

use App\Helpers\LinkUtils;
use App\Helpers\Logger\SLogger;
use App\Helpers\RestResponseFactory;
use App\Helpers\RestUtils;
use App\Http\Controllers\Api\ApiController;
use App\Models\Factory\Api\InviteFactory;
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
class InviteController extends ApiController
{
    /**
     * @param Request $request
     * 用户邀请信息
     */
    public function link(Request $request)
    {
        $uid = $this->getUserId($request);
        //用户名
        $inviteArr['username'] = UserAuthFactory::fetchUserName($uid);
        //分享链接
        $inviteCode = InviteFactory::fetchInviteCode($uid);
        $inviteArr['share_link'] = LinkUtils::shareLanding($inviteCode);
        print_r($inviteArr['share_link']);die;
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
        $uid = $this->getUserId($request);
        $sizeArr = $request->all();
        //邀请码
        $inviteCode = InviteFactory::fetchInviteCode($uid);
        //扫码链接
        $landig = LinkUtils::shareLanding($inviteCode);
        return QrCode::size($sizeArr['size'])->generate($landig);
    }

    /**邀请好友页面
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
//    public function home(){
//        return view();
//    }

}