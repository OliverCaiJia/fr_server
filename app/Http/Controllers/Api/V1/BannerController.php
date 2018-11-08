<?php
namespace App\Http\Controllers\Api\V1;

use App\Helpers\Http\HttpClient;
use App\Helpers\RestResponseFactory;
use App\Http\Controllers\Api\ApiController;
use App\Services\Core\Validator\ValidatorService;
use function Couchbase\defaultDecoder;

class BannerController extends ApiController
{
    public function order() {
        $res = [
            ["src" => "http://image.sudaizhijia.com/test/20170802/banner/20170802152334-780.jpg",
                "app_url" => "zixun79",
                "h5_link" => "http://uat.m.sudaizhijia.com/html/login.html",
                "name" => "我的",
                "footer_img_h5_link" => "https://uat.m.sudaizhijia.com/html/consultApp2.2.html?newsId=79"],
            ["src" => "http://image.sudaizhijia.com/test/20170802/banner/20170802150412-225.jpg",
                "app_url"=> "205",
                "h5_link"=> "https://www.baidu.com/",
                "name"=> "速贷大全",
                "footer_img_h5_link"=> ""]
        ];
        return RestResponseFactory::ok($res);
    }

    public function report() {
        return RestResponseFactory::ok();
    }

    public function home() {
        return RestResponseFactory::ok();
    }


    public function groom(Request $request)
    {
        return RestResponseFactory::ok();
    }
}