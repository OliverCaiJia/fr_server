<?php

namespace App\Http\Controllers\Web\V1;

use Illuminate\Http\Request;
use App\Http\Controllers\Web\WebController;

class UserController extends WebController
{

    public function report(Request $request)
    {
        $data = [];
        return view('web.user.report', $data);
    }

    public function createReport()
    {
        return view('web.user.createreport');
    }

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function userinfo()
    {
        return view('web.user.userinfo');
    }
}
