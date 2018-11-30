<?php

namespace App\Models\Chain\Report\Scopion;

use App\Constants\OrderConstant;
use App\Helpers\Logger\SLogger;
use App\Models\Chain\AbstractHandler;
use App\Models\Factory\Api\UserOrderFactory;

class CreatePostLoanAction extends AbstractHandler
{
    private $params = [];
    protected $error = ['error' => '订单状态不合法，审核（拒绝）失败！', 'code' => 8210];

    public function     __construct($params)
    {
        $this->params = $params;
    }

    /**
     *
     *
     * @return array
     */
    public function handleRequest()
    {
        if ($this->createPostloan($this->params)) {
            $this->setSuccessor(new CreateBlackListAction($this->params));
            return $this->getSuccessor()->handleRequest();
        } else {
            return $this->error;
        }

//        $result = UserOrderFactory::createOrderReport($this->params);
//        if ($result) {
//            return true;
//        }
//        return $this->error;
    }

    private function createPostloan($params)
    {
        SLogger::getStream()->error(__CLASS__);

//        CREATE TABLE `sgd_user_postloan` (
//    `id` int(11) unsigned NOT NULL AUTO_INCREMENT COMMENT 'id',
//  `user_id` int(11) unsigned NOT NULL COMMENT '用户id',
//  `user_report_id` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '关联的jt_user_reports表的id',
//  `transid` varchar(128) NOT NULL DEFAULT '' COMMENT '传输id',
//  `due_days_non_cdq_12_mon` int(8) NOT NULL COMMENT '近12个月最近一次非超短期现金贷逾期距今天数(',
//  `pay_cnt_12_mon` int(8) NOT NULL DEFAULT '0' COMMENT '近12个月累计还款笔数',
//  `data` json NOT NULL COMMENT '贷后行为',
//  `fee` varchar(255) NOT NULL DEFAULT '',
//  `create_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP COMMENT '创建时间',
//  `update_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP COMMENT '更新时间',
//  PRIMARY KEY (`id`),
//  KEY `FK_USER_POSTLOAN_USER_ID` (`user_id`),
//  CONSTRAINT `FK_USER_POSTLOAN_USER_ID` FOREIGN KEY (`user_id`) REFERENCES `sgd_user_auth` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
//) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COMMENT='用户贷后数据表'

        //        array:5 [▼
//  "success" => true
//  "code" => "0000"
//  "msg" => "操作成功"
//  "data" => array:3 [▼
//    "trans_id" => "d129ed00-ecbd-11e8-bea7-00163e0d2aee"
//    "person_info" => array:10 [▼
//      "idcard" => "13070219811107****"
//      "idcard_location" => "河北省/张家口市/桥东区"
//      "mobile" => "1381056****"
//      "carrier" => "中国移动"
//      "mobile_location" => "北京/北京"
//      "name" => "蔡*"
//      "age" => 37
//      "gender" => "男"
//      "email" => ""
//      "education_info" => array:2 [▼
//        "level" => 0
//        "is_graduation" => false
//      ]
//    ]
//    "loan_behavior_analysis" => array:7 [▼
//      "defaultday_from_first_to_end" => ""
//      "feature_7d" => array:12 [▼
//        "jiedai4_sum_fail_cnt_d7" => ""
//        "jiedai_avg_defaultdays_d7" => ""
//        "jiedai4_count_fill_d3_cnt_d7" => ""
//        "jiedai_max_defaultdays_d7" => ""
//        "dd_jiedai_sum_fill_d5_cnt_d7" => ""
//        "dd_jiedai_count_fail_mamberadd_d7" => ""
//        "dd_jiedai_avg_fail_days1_d7" => ""
//        "jiedai_min_defaultdays_d7" => ""
//        "last_to_end_sure_due_all_pro_all_time_d7" => ""
//        "max_sure_due_days_non_cdq_all_time_d7" => ""
//        "sum_sure_due_days_all_pro_all_time_d7" => ""
//        "last_to_end_sure_due_non_cdq_all_time_d7" => ""
//      ]
//      "feature_15d" => array:13 [▼
//        "jiedai_avg_defaultdays_d15" => ""
//        "jiedai_min_defaultdays_d15" => ""
//        "jiedai4_sum_fail_cnt_d15" => ""
//        "dd_jiedai_avg_fail_days1_d15" => ""
//        "jiedai4_count_fill_d3_cnt_d15" => ""
//        "jiedai4_count_fill_d5_cnt_d15" => ""
//        "dd_jiedai_count_fail_mamberadd_d15" => ""
//        "jiedai_sum_fail_amt_d15" => ""
//        "dd_jiedai_max_fail_days1_d15" => ""
//        "sum_sure_due_days_all_pro_all_time_d15" => ""
//        "last_to_end_sure_due_all_pro_all_time_d15" => ""
//        "max_sure_due_days_non_cdq_all_time_d15" => ""
//        "last_to_end_sure_due_non_cdq_all_time_d15" => ""
//      ]
//      "feature_30d" => array:16 [▼
//        "jiedai_avg_defaultdays_m1" => ""
//        "dd_jiedai_max_fail_days1_m1" => ""
//        "jiedai4_sum_fail_cnt1" => ""
//        "dd_jiedai_max_fail_days_m1" => ""
//        "dd_jiedai_count_fail_mamberadd_m1" => ""
//        "jiedai4_count_fill_d3_cnt_m1" => ""
//        "dd_jiedai_min_fail_days1_m1" => ""
//        "jiedai_sum_fail_amt1" => ""
//        "cdq_dd_jiedai_max_fail_days1_m1" => ""
//        "jiedai4_count_fill_d5_cnt_m1" => ""
//        "jiedai4_avg_succ_amt1" => ""
//        "sum_sure_due_days_non_cdq_all_time_m1" => ""
//        "sum_sure_due_days_all_pro_all_time_m1" => ""
//        "avg_sure_due_days_non_cdq_all_time_m1" => ""
//        "pct_pay_amt_cdq_pro_all_time_m1" => ""
//        "max_pay_amt_all_pro_all_time_m1" => ""
//      ]
//      "feature_90d" => array:16 [▼
//        "jiedai_avg_defaultdays_m3" => ""
//        "dd_jiedai_max_fail_days1_m3" => ""
//        "dd_jiedai_avg_fail_days_m3" => ""
//        "dd_jiedai_count_fail_mamberadd_m3" => ""
//        "jiedai4_count_fill_d3_cnt_m3" => ""
//        "jiedai4_count_fill_d5_cnt_m3" => ""
//        "cdq_dd_jiedai_avg_fail_days1_m3" => ""
//        "jiedai4_avg_succ_amt3" => ""
//        "jiedai_sum_fail_amt3" => ""
//        "dd_jiedai_min_fail_days1_m3" => ""
//        "sum_sure_due_days_all_pro_all_time_m3" => ""
//        "sum_sure_due_days_non_cdq_all_time_m3" => ""
//        "avg_sure_due_days_all_pro_all_time_m3" => ""
//        "max_due_cnt_non_cdq_all_time_m3" => ""
//        "avg_sure_due_days_non_cdq_all_time_m3" => ""
//        "pct_pay_amt_cdq_pro_all_time_m3" => ""
//      ]
//      "feature_180d" => array:14 [▼
//        "jiedai_avg_defaultdays_m6" => ""
//        "dd_jiedai_avg_fail_days1_m6" => ""
//        "dd_jiedai_avg_fail_days_m6" => ""
//        "dd_jiedai_count_fail_mamberadd_m6" => ""
//        "jiedai4_count_fill_d3_cnt_m6" => ""
//        "cdq_dd_jiedai_avg_fail_days1_m6" => ""
//        "cdq_dd_jiedai_max_fail_days1_m6" => ""
//        "jiedai4_avg_succ_amt6" => ""
//        "jiedai4_count_fill_d5_cnt_m6" => ""
//        "sum_sure_due_days_non_cdq_all_time_m6" => ""
//        "max_sure_due_days_all_pro_all_time_m6" => ""
//        "avg_sure_due_days_all_pro_all_time_m6" => ""
//        "avg_sure_due_days_non_cdq_all_time_m6" => ""
//        "pct_pay_amt_cdq_pro_all_time_m6" => ""
//      ]
//      "feature_360d" => array:9 [▼
//        "dd_jiedai_max_fail_days_m12" => ""
//        "dd_jiedai_sum_fill_d5_cnt_m12" => ""
//        "last_to_end_sure_due_all_pro_all_time_m12" => ""
//        "sum_sure_due_days_non_cdq_all_time_m12" => ""
//        "last_to_end_sure_due_non_cdq_all_time_m12" => ""
//        "max_due_cnt_all_pro_all_time_m12" => ""
//        "max_due_cnt_non_cdq_all_time_m12" => ""
//        "max_pay_amt_all_pro_all_time_m12" => ""
//        "sum_pay_cnt_all_pro_all_time_m12" => ""
//      ]
//    ]
//  ]
//  "fee" => "N"
//]


        $data['user_id'] = $params['user_id'];//6
        $data['user_report_id'] = $params['user_report_id'];//1
        $data['transid'] = $params['post_load']['data']['trans_id'];//1
        $data['due_days_non_cdq_12_mon'] = $params['post_load']['data']['loan_behavior_analysis']['feature_360d']['last_to_end_sure_due_non_cdq_all_time_m12'];//
        $data['pay_cnt_12_mon'] = $params['post_load']['data']['loan_behavior_analysis']['feature_360d']['sum_pay_cnt_all_pro_all_time_m12'];//1
        $data['data'] = json_encode($params['post_load']['data']);//
        $data['fee'] = $params['post_load']['fee'];//'Y'
        $data['create_at'] = date('Y-m-d H:i:s', time());
        $data['update_at'] = date('Y-m-d H:i:s', time());

//        dd($data);
//        array:9 [▼
//  "user_id" => 6
//  "user_report_id" => 111
//  "transid" => "dbc514d0-ee0a-11e8-a3bc-00163e0ed28c"
//  "due_days_non_cdq_12_mon" => ""
//  "pay_cnt_12_mon" => ""
//  "data" => "{"trans_id":"dbc514d0-ee0a-11e8-a3bc-00163e0ed28c","person_info":{"idcard":"61030319791111****","idcard_location":"\u9655\u897f\u7701\/\u5b9d\u9e21\u5e02\/\u91d ▶"
//  "fee" => "N"
//  "create_at" => "2018-11-22 14:33:33"
//  "update_at" => "2018-11-22 14:33:33"
//]



        $userPostLoan = UserOrderFactory::createPostloan($data);

//        $userId = $params['user_id'];
//        $orderType = $params['order_type'];
//        $userOrder = UserOrderFactory::getUserOrderByUserIdAndOrderType($userId, $orderType);
//
        if (!$userPostLoan) {
            $this->error['error'] = "您好，报告记录关系异常！";
            return false;
        }
        return true;
    }
}
