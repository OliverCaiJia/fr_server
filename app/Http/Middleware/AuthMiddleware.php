<?php

namespace App\Http\Middleware;

use Closure;
use \App;
use Illuminate\Support\Facades\Auth;
use \Request;
use App\Models\Orm\UserAuth;
use App\Helpers\RestResponseFactory;

/**
 * 获取用户中间件
 *
 * @author zhaoqiying
 */
class AuthMiddleware
{

    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        $token = $request->input('token') ?: $request->header('X-Token');
        if ($token) {
            $user = UserAuth::where('accessToken', $token)->first();
            if ($user) {
                Auth::login($user);
            } else {
                return RestResponseFactory::unauthorized('Unauthorized', 401, 'Unauthorized');
            }
        }
        return $next($request);
    }

}
