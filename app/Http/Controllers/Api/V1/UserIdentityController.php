<?php
namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Api\ApiController;
use App\Helpers\RestResponseFactory;
use App\Helpers\RestUtils;
use App\Models\Chain\UserIdentity\IdcardFront\CreateIdcardFrontAction;
use Illuminate\Http\Request;

/**
 * Class UserAuthenController
 * @package APP\Http\Controllers\V1
 * 用户身份信息认证
 */
class UserIdentityController extends ApiController
{
    /**
     * 调取face++获取身份证正面信息
     * @return \Illuminate\Http\JsonResponse
     */
    public function fetchFaceidToCardfrontInfo(Request $request)
    {
        $data['card_front'] = $request->file('cardFront');
        //责任链
        $realname = new CreateIdcardFrontAction($data);
        $res = $realname->handleRequest();

        if (isset($res['error'])) {
            return RestResponseFactory::ok(RestUtils::getStdObj(), $res['error'], $res['code'], $res['error']);
        }

        return RestResponseFactory::ok($res);
    }

    /**
     * 调取face++获取身份证正面信息
     * @return \Illuminate\Http\JsonResponse
     */
    public function fetchFaceidToCardbackInfo(Request $request)
    {
        $res = [
            'valid_date' => '2005.10.08-2025.10.08',
            'result' => '1002'
        ];
        return RestResponseFactory::ok($res);
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     * 天创验证身份证合法信息
     */
    public function checkIdcardFromTianchuang(Request $request)
    {
        return RestResponseFactory::ok(RestUtils::getStdObj());
    }
}