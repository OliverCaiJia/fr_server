<?php

namespace App\Http\Controllers\Web\V1;

use App\Http\Controllers\Web\WebController;
use Illuminate\Support\Facades\Request;

class AgreementController extends WebController
{

    /**
     * 
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function register(Request $request)
    {
        $data = [];
        return view('web.agreement.register', $data);
    }

    /**
     * 
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function credit(Request $request)
    {
        $data = [];
        return view('web.agreement.credit', $data);
    }

    /**
     * 
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function faceid(Request $request)
    {
        $data = [];
        return view('web.agreement.faceid', $data);
    }

}
