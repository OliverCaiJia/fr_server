<?php
namespace App\Http\Controllers\Api\V1;

use App\Constants\ConfigConstant;
use App\Helpers\DateUtils;
use App\Helpers\LinkUtils;
use App\Helpers\Logger\SLogger;
use App\Helpers\RestResponseFactory;
use App\Helpers\RestUtils;
use App\Http\Controllers\Controller;
use App\Models\Factory\ConfigFactory;
use App\Models\Factory\InviteFactory;
use App\Models\Factory\UserFactory;
use App\Models\Orm\SystemConfig;
use App\Strategies\InviteStrategy;
use App\Strategies\SmsStrategy;
use Illuminate\Http\Request;
use SimpleSoftwareIO\QrCode\Facades\QrCode;
use App\Constants\InviteConstant;

/**
 * Class InviteController
 * @package App\Http\Controllers\V1
 * 邀请
 */
class InviteController extends Controller
{
    /**
     * @param Request $request
     * 用户邀请信息
     */
    public function link(Request $request)
    {
        //分享链接
        $data = ['share_link' => "https://m.sudaizhijia.com/html/mine_aboutour.html?sd_invite_code=1612cMSjoD"];
        return RestResponseFactory::ok($data);
    }

    /**
     * @return mixed
     * 生成二维码
     */
    public function sqcode(Request $request)
    {
        return RestResponseFactory::ok();
    }

}