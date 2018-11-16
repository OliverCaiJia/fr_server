<?php

namespace App\Http\Controllers\Web\V1;

use Illuminate\Http\Request;
use App\Strategies\InviteStrategy;
use App\Http\Controllers\Web\WebController;
use App\Models\Factory\Web\UserInviteFactory;


class InviteController extends WebController
{
    /**
     * 获取用户成功邀请列表
     * @param Request $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function home(Request $request)
    {
        $userId = $this->getUserId($request);

        $data = InviteStrategy::getInvitedUsers($userId);
        $count = (count($data)*36) ?? 0;

        return view('web.invite.home', compact('data','count'));
    }
}
