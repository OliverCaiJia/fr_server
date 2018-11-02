<?php

namespace App\Http\Controllers\Admin\Saas;

use App\Constants\RechargeConstant;
use App\Models\Factory\Admin\Saas\SaasAuthFactory;
use App\Models\Factory\Admin\Saas\SaasPersonFactory;
use App\Models\Orm\AccountRecharge;
use App\Http\Controllers\Controller;
use Auth;

class AccountController extends Controller
{
    /**
     * 充值记录
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index()
    {
        $data = AccountRecharge::orderBy('id', 'desc')
            ->where([
                'status' => RechargeConstant::RECHARGE_STATUS_FINISHED,
                'saas_user_id' => SaasPersonFactory::getSaasAuthById(Auth::user()->id)
            ])->paginate(10);
        $saasAuthId = SaasPersonFactory::getSaasAuthById(Auth::user()->id);
        $saasAuth = SaasAuthFactory::getSaasAuthById($saasAuthId);

        return view('admin.account.index', compact('data', 'saasAuth'));
    }
}
