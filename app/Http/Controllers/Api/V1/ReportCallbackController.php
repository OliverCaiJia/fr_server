<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Api\ApiController;
use App\Models\Factory\Api\UserRealnameFactory;
use App\Services\Core\Validator\Scorpion\Mozhang\MozhangService;
use Illuminate\Http\Request;

class ReportCallbackController extends ApiController
{

    public function create(Request $request)
    {
//        $par = [];
//        $par['name'] = '蔡嘉';
//        $par['idCard'] = '130702198111071511';
//        $par['mobile'] = '18510536684';
//        $par['num'] = 0;
        $userId = $this->getUserId($request);
        $userRealName = UserRealnameFactory::fetchUserRealname($userId);
        dd($userRealName);

        $pullResult = MozhangService::o()->getMoZhangContent($par['name'], $par['idCard'], $par['mobile'], $par['num']);
        dd($pullResult);
    }
}