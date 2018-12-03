<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    /**
     * Instantiate a new Controller instance.
     */
    public function __construct()
    {
        date_default_timezone_set('Asia/Shanghai'); //时区配置
    }
    /**
     * 判断请求方式
     * @param Request $request
     * @return type
     */
    public function isPostMethod(Request $request)
    {
        return $request->isMethod('POST');
    }

    /**
     * 判断请求方式
     * @param Request $request
     * @return type
     */
    public function isGetMethod(Request $request)
    {
        return $request->isMethod('GET');
    }

    /**
     * 判断请求方式
     * @param Request $request
     * @return type
     */
    public function isPutMethod(Request $request)
    {
        return $request->isMethod('PUT');
    }

    /**
     * 判断请求方式
     * @param Request $request
     * @return type
     */
    public function isDeleteMethod(Request $request)
    {
        return $request->isMethod('DELETE');
    }


    public function getToken($request)
    {
        return $request->input('token') ?: $request->header('X-Token');
    }

    public function getUserId($request)
    {
        return $request->user()->sd_user_id ?: null;
    }
}
