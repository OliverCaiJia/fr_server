<?php

namespace App\Http\Controllers\Web\V1;

use App\Http\Controllers\Web\WebController;
use Illuminate\Support\Facades\Request;

class UserController extends WebController
{

    /**
     * 
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function report(Request $request)
    {
        $data = [];
        return view('web.user.report', $data);
    }
}
