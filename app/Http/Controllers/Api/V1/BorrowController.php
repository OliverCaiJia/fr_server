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
            [
                'mobile' => '135****3965',
                'money' => 3000,
                'time' => 4
            ],
            [
                'mobile' => '137****5462',
                'money' => 3500,
                'time' => 5
            ],
            [
                'mobile' => '138****9257',
                'money' => 4000,
                'time' => 8
            ],
            [
                'mobile' => '135****3762',
                'money' => 5000,
                'time' => 6
            ],
            [
                'mobile' => '187****3937',
                'money' => 3100,
                'time' => 2
            ],
            [
                'mobile' => '138****5428',
                'money' => 6000,
                'time' => 10
            ],
            [
                'mobile' => '131****8512',
                'money' => 5000,
                'time' => 8
            ],
            [
                'mobile' => '131****3488',
                'money' => 3000,
                'time' => 4
            ],
            [
                'mobile' => '152****5675',
                'money' => 5000,
                'time' => 10
            ],
            [
                'mobile' => '156****1814',
                'money' => 5000,
                'time' => 3
            ],
            [
                'mobile' => '155****5564',
                'money' => 300,
                'time' => 4
            ],
            [
                'mobile' => '155****1547',
                'money' => 6000,
                'time' => 5
            ],
            [
                'mobile' => '185****3932',
                'money' => 5600,
                'time' => 15
            ],
            [
                'mobile' => '185****4725',
                'money' => 6000,
                'time' => 2
            ],
            [
                'mobile' => '152****5647',
                'money' =>4800,
                'time' => 9
            ]
        ];
        //随机选择出10个
        $temp=array_rand($res,10);
        //重组数组
        foreach($temp as $val){
            $data_last[]=$res[$val];
        }
        return RestResponseFactory::ok($data_last);
    }

    /**
     * 获取首页默认配置
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */

    public function default()
    {
        $moeny_min = 'home_min_loan_amount'; //金额最小值
        $moeny_max = 'home_max_loan_amount'; //金额最大值
        $moeny_default = 'home_default_loan_amount'; //金额默认值
        $term_min = 'home_min_loan_period'; //期限最小值
        $term_max = 'home_max_loan_period'; //期限最大值
        $term_default = 'home_default_loan_period'; //期限默认值

        $home_default_keys = [
            $moeny_min,
            $moeny_max,
            $moeny_default,
            $term_min,
            $term_max,
            $term_default
        ];
        $homeDefault = SysConfigFactory::getSysByKey($home_default_keys);

        $data = [];
        if(!empty($homeDefault)) {
            //数据整理
            foreach ($homeDefault as $home_key => $home_val) {
                foreach ($home_default_keys as $default_key => $default_val) {
                    if ($home_val['key'] == $default_val) {
                        $res[$default_val] = $home_val['value'];
                    }
                }
            }
            $data = [
                'moeny_min' => $res[$moeny_min],
                'moeny_max' => $res[$moeny_max],
                'moeny_default' => $res[$moeny_default],
                'term_min' => $res[$term_min],
                'term_max' => $res[$term_max],
                'term_default' => $res[$term_default],
            ];
        }

        return RestResponseFactory::ok($data);
    }
}