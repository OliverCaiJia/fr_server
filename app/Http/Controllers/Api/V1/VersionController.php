<?php

namespace App\Http\Controllers\Api\V1;

use App\Helpers\RestUtils;
use App\Strategies\VersionStrategy;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Helpers\RestResponseFactory;
use App\Models\Factory\VersionFactory;

class VersionController extends Controller
{
    /**
     * @param Request $request
     * @return mixed
     */
    public function upgrade(Request $request)
    {
        $data = ['version' => '1.0'];
        return RestResponseFactory::ok($data);
    }

}
