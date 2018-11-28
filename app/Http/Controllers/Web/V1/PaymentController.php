<?php

namespace App\Http\Controllers\Web\V1;

use Illuminate\Http\Request;
use App\Http\Controllers\Web\WebController;

class PaymentController extends WebController
{

    public function success(Request $request)
    {
        return view('web.user.report');
    }
}
