<?php

namespace App\Http\Middleware;

use App\Models\Orm\SaasPermission;
use App\Strategies\PermissionStrategy;
use Closure;
use Cache;

class GetMenu
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  \Closure                 $next
     *
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        $request->attributes->set('comData_menu', $this->getMenu());

        return $next($request);
    }

    /**
     * 获取左边菜单栏
     *
     * @return array
     */
    public function getMenu()
    {
        $table = Cache::rememberForever('menus', function () {
            return SaasPermission::where('is_display', '1')
                ->get()
                ->toArray();
        });

        return PermissionStrategy::generateTree($table);
    }
}
