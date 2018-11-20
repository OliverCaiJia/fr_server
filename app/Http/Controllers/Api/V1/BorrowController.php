<?php

namespace App\Http\Controllers\Api\V1;

use App\Helpers\RestResponseFactory;
use App\Http\Controllers\Api\ApiController;
use App\Models\Factory\Api\SysConfigFactory;

class BorrowController extends ApiController
{
    public function home()
    {
        $res = [
            "id" => 1760,
            "user_id" => 1288,
            "platform_product_id" => 286,
            "platform_id" => 126,
            "is_urge" => 0,
            "is_comment" => 0,
            "created_at" => "2018-01-13申请",
            "created_time" => "2018/01/13",
            "platform_product_name" => "未跑批夸两句",
            "product_logo" => "http://image.sudaizhijia.com/test/20171225/platform/20171225133701-785.jpg",
            "loan_money" => "5万-1500万元",
            "period_time" => "24-60月",
            "service_mobile" => ""
        ];
        return RestResponseFactory::ok($res);
    }

    /**
     * 获取首页默认配置
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */

    public function default()
    {
        $home_default_keys = [
            'home_default_loan_amount',
            'home_min_loan_amount',
            'home_max_loan_amount',
            'home_default_loan_period',
            'home_min_loan_period',
            'home_max_loan_period'
        ];
        $homeDefault = SysConfigFactory::getSysByKey($home_default_keys);

        $res = [];
        if($homeDefault)
           //数据整理
            foreach ($homeDefault as $home_key => $home_val){
                foreach ($home_default_keys as $default_key => $default_val){
                    if($home_val['key'] == $default_val){
                        $res[$default_val] = $home_val['value'];
                    }
                }
            }
        $data = [
            'moeny_min' => $res['home_min_loan_amount'],
            'moeny_max' => $res['home_max_loan_amount'],
            'moeny_default' => $res['home_default_loan_amount'],
            'term_min' => $res['home_min_loan_period'],
            'term_max' => $res['home_max_loan_period'],
            'term_default' => $res['home_default_loan_period'],
        ];
        return RestResponseFactory::ok($data);
    }
}