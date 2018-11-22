<?php

namespace App\Providers;

use App\Models\Orm\UserAuth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\ServiceProvider;

class ApiTokenServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap the application services.
     *
     * @return void
     */
    public function boot(Request $request)
    {
        //
        $token = $request->input('token') ?: $request->header('X-Token');
        if ($token)
        {
            $user = UserAuth::where('access_token', $token)->first();
            if($user){
                 Auth::login($user);
            }          
        }
    }

    /**
     * Register the application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }
}
