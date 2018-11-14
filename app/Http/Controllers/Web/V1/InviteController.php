<?php

namespace App\Http\Controllers\Web\V1;

use App\Http\Controllers\Web\WebController;
use Illuminate\Support\Facades\Request;

class InviteController extends WebController
{

    /**
     * 
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function home(Request $request)
    {
        $data = [];
        return view('web.invite.home', $data);
    }
}
