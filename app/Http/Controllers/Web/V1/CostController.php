<?php

namespace App\Http\Controllers\Web\V1;

use Illuminate\Http\Request;
use App\Strategies\InviteStrategy;
use App\Http\Controllers\Web\WebController;
use App\Models\Factory\Web\UserInviteFactory;


class CostController extends WebController
{
    /**
     * 推荐服务列表
     * @param Request $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function costDefault(Request $request)
    {
        return view('web.cost.costdefault');
    }
}
