<?php

namespace App\Http\Controllers\Admin\Auth;

use App\Http\Controllers\Controller;
use App\Models\Factory\Admin\Saas\SaasAuthFactory;
use App\Models\Factory\Admin\Saas\SaasPersonFactory;
use App\Models\Orm\SaasAuth;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;
use Auth;

class LoginController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles authenticating users for the application and
    | redirecting them to your home screen. The controller uses a trait
    | to conveniently provide its functionality to your applications.
    |
    */

    use AuthenticatesUsers;

    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    protected $redirectTo = '/admin';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest:admin')->except('logout');
    }

    /**
     * Get the guard to be used during authentication.
     *
     * @return \Illuminate\Contracts\Auth\StatefulGuard
     */
    protected function guard()
    {
        return Auth::guard('admin');
    }

    /**
     * Get the login username to be used by the controller.
     *
     * @return string
     */
    public function username()
    {
        return 'username';
    }

    /**
     * Log the user out of the application.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function logout(Request $request)
    {
        $this->guard('admin')->logout();

        $request->session()->invalidate();

        return redirect('/');
    }

    /**
     * The user has been authenticated.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  mixed  $user
     * @return mixed
     */
    protected function authenticated(Request $request, $user)
    {
        if ($this->validateStatus($user)) {
            $this->guard('admin')->logout();
            $request->session()->invalidate();

            return redirect()->route('admin.login')->withErrors(['username' => '账户不可用']);
        }
    }

    /**
     * 校验用户帐号状态
     * @param $user
     * @return bool
     */
    protected function validateStatus($user)
    {
        if ($user->is_deleted) {                                             // 帐号删除，禁止登录
            return true;
        }

        $saasInfo = SaasAuthFactory::getSaasInfoById($user->saas_auth_id);
        if (!$saasInfo) {                                                    // 主帐号不存在，禁止登录
            return true;
        } elseif ($saasInfo->is_locked) {                                    // 合作方账户冻结，禁止登录
            return true;
        } elseif (strtotime($saasInfo->valid_deadline) < time()) {           // 合作方帐号超过有效期，禁止登录
            return true;
        } elseif ($saasInfo->is_deleted) {
            return true;
        }

        return false;
    }
}
