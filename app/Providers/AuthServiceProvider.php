<?php

namespace App\Providers;

use App\Models\Orm\SaasPermission;
use Illuminate\Contracts\Auth\Access\Gate as GateContract;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The policy mappings for the application.
     *
     * @var array
     */
    protected $policies = [
        'App\Model' => 'App\Policies\ModelPolicy',
    ];

    /**
     * Register any authentication / authorization services.
     *
     * @param \Illuminate\Contracts\Auth\Access\Gate $gate
     *
     * @return bool
     */
    public function boot(GateContract $gate)
    {
        if (!empty($_SERVER['SCRIPT_NAME']) && strtolower($_SERVER['SCRIPT_NAME']) === 'artisan') {
            return false;
        }

        $gate->before(function ($user, $ability) {
            if ($user->super_user === 1) {
                return true;
            }
        });

        $this->registerPolicies($gate);

        $permissions = SaasPermission::with('roles')->get();

        foreach ($permissions as $permission) {
            $gate->define($permission->name, function ($user) use ($permission) {
                return $user->hasPermission($permission);
            });
        }
    }
}
