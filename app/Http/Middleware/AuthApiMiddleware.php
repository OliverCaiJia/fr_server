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
class AuthApiMiddleware
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
            $user = UserAuth::where('access_token', $token)->first();
            if (isset($user)) {
                Auth::login($user);
            } else {
                return RestResponseFactory::unauthorized('Unauthorized', 401, 'Unauthorized');
            }
            return $next($request);
        }
        return RestResponseFactory::unauthorized('Unauthorized', 401, 'Unauthorized');
    }

}
