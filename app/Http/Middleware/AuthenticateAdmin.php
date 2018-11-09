<?php

namespace App\Http\Middleware;

use App\Strategies\AdminAuthStrategy;
use Closure;
use Route;
use URL;
use Auth;

class AuthenticateAdmin
{
    protected $except = [
        'admin.index',
        'admin.main'
    ];

    /**
     * Handle an incoming request.
     *
     * @param         $request
     * @param Closure $next
     *
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        $user = Auth::guard('admin')->user();

        $isValid = AdminAuthStrategy::isAvailableAccount($user->saas_auth_id);
        if (!$isValid || ($user->is_deleted == 1)) {
            Auth::guard('admin')->logout();
            $request->session()->invalidate();

            return redirect()->route('admin.login')->withErrors(['username' => '账户不可用']);
        }

        if ($user->super_user === 1) {
            return $next($request);
        }

        $previousUrl = URL::previous();
        $routeName = Route::currentRouteName();
        if ($request->user()->cannot($routeName) && !in_array($routeName, $this->except)) {
            if ($request->ajax() && ($request->getMethod() != 'GET')) {
                return response()->json([
                    'status' => -1,
                    'code' => 403,
                    'msg' => '您没有权限执行此操作',
                ]);
            } else {
                return response()->view('errors.403', compact('previousUrl'));
            }
        }

        return $next($request);
    }
}
