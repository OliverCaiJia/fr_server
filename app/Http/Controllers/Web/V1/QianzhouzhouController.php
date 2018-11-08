<?php

namespace App\Http\Controllers\Web\V1;

use App\Constants\BannersConstant;
use App\Helpers\RestResponseFactory;
use App\Helpers\RestUtils;
use App\Http\Controllers\Controller;
use App\Models\Factory\BannersFactory;
use App\Models\Factory\NewsFactory;
use App\Models\Factory\PushFactory;
use App\Strategies\BannerStrategy;
use App\Strategies\NewStrategy;
use App\Strategies\PushStrategy;
use Illuminate\Http\Request;
use App\Models\ComModelFactory;

/**
 * Default controller for the `api` module
 */
class BannersController extends Controller
{


    /**
     * ����ҳ���
     */
    public function launchAdvertisement()
    {
//����ҳ��λ��
        $position = 3;
//��ѯ��Ҫ���͵���Ϣ
        $push = PushFactory::fetchPopup($position);
        if (empty($push)) {
            return RestResponseFactory::ok(RestUtils::getStdObj(), RestUtils::getErrorMessage(1500), 1500); //��������
        }
//ִ�д�������
        PushFactory::updateDoCounts($push['id']);
        $pushArr = PushStrategy::getPopup($push);
        return RestResponseFactory::ok($pushArr);
    }
}