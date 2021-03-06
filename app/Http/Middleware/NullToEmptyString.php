<?php

namespace App\Http\Middleware;


use Closure;

class NullToEmptyString
{
    /**
     * The attributes that should not be trimmed.
     *
     * @var array
     */
    protected $except = [
        //
    ];

    /**
     * Transform the given value.
     *
     * @param  string  $key
     * @param  mixed  $value
     * @return mixed
     */
    public function handle($request ,Closure $next)
    {
        $params = $request->input();
        $arr = [];
        foreach ($params as $key => $param)
        {
            $arr[$key] = (empty($param) & !is_bool($param) ) ? "" : $param;
        }
        $request->merge($arr);

        return $next($request);
    }
}
