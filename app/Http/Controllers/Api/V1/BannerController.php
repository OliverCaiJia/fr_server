<?php

namespace App\Http\Controllers\Api\V1;

use App\Helpers\Http\HttpClient;
use App\Helpers\RestResponseFactory;
use App\Helpers\RestUtils;
use App\Http\Controllers\Api\ApiController;
use App\Services\Core\Validator\ValidatorService;
use App\Models\Factory\Api\BannerFactory;
use Illuminate\Http\Request;
use function Couchbase\defaultDecoder;

class BannerController extends ApiController
{
    public function order()
    {
        $res = [
            ["src" => "http://image.jdt.com/test/20170802/banner/20170802152334-780.jpg",
                "app_url" => "zixun79",
                "h5_link" => "http://at.m.jdt.com/html/login.html",
                "name" => "我的",
                "footer_img_h5_link" => "https://at.m.jdt.com/html/consultApp2.2.html?newsId=79"],
            ["src" => "http://image.jdt.com/test/20170802/banner/20170802150412-225.jpg",
                "app_url" => "205",
                "h5_link" => "https://www.google.com/",
                "name" => "jdt",
                "footer_img_h5_link" => ""]
        ];
        return RestResponseFactory::ok($res);
    }

    public function report()
    {
        return RestResponseFactory::ok();
    }

    /**查询banner图
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function home(Request $request)
    {
        $type = $request->input('type');
        $data = BannerFactory::IsBanner($type);
        if (empty($data)) {
            return RestResponseFactory::ok(RestUtils::getStdObj(), RestUtils::getErrorMessage(1500), 1500);
        }
        return RestResponseFactory::ok($data);
    }


    public function groom(Request $request)
    {
        return RestResponseFactory::ok();
    }
}