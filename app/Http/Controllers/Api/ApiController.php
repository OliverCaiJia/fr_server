<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller as BaseController;

class ApiController extends BaseController
{

    /**
     * Instantiate a new Controller instance.
     */
    public function __construct()
    {
        date_default_timezone_set('Asia/Shanghai'); //时区配置
    }

    public function getToken($request)
    {
        return $request->input('token') ?: $request->header('X-Token');
    }

    public function getUserId($request)
    {
        return $request->user()->id ?: null;
    }

}
