<?php

namespace App\Models\Chain\Report\Scopion;

use App\Constants\OrderConstant;
use App\Helpers\Logger\SLogger;
use App\Models\Chain\AbstractHandler;
use App\Models\Factory\Api\UserOrderFactory;

class CreateApplyAction extends AbstractHandler
{
    private $params = [];
    protected $error = ['error' => '订单状态不合法，审核（拒绝）失败！', 'code' => 8210];

    public function __construct($params)
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
        if ($this->createApply($this->params)) {
            $this->setSuccessor(new CreateAmountEstAction($this->params));
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

    private function createApply($params)
    {
        SLogger::getStream()->error(__CLASS__);

//        CREATE TABLE `sgd_user_apply` (
//    `id` int(11) unsigned NOT NULL AUTO_INCREMENT COMMENT 'id',
//  `user_id` int(11) unsigned DEFAULT NULL COMMENT '用户id',
//  `user_report_id` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '关联的jt_user_reports表的id',
//  `transid` varchar(128) NOT NULL DEFAULT '' COMMENT '传输id',
//  `data` json NOT NULL,
//  `fee` varchar(255) NOT NULL DEFAULT '' COMMENT '收费',
//  `create_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP COMMENT '创建时间',
//  `update_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP COMMENT '更新时间',
//  PRIMARY KEY (`id`),
//  UNIQUE KEY `FK_USER_APPLYIN_USER_ID` (`user_id`) USING BTREE,
//  CONSTRAINT `FK_USER_APPLYIN_USER_ID` FOREIGN KEY (`user_id`) REFERENCES `sgd_user_auth` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
//) ENGINE=InnoDB AUTO_INCREMENT=26 DEFAULT CHARSET=utf8mb4 COMMENT='用户注入信息表'


//        dd($params);


//
//        array:11 [▼
//  "user_report_type_id" => 1
//  "user_id" => 6
//  "order_id" => 91
//  "anti_fraud" => array:5 [▶]
//  "report_data" => array:6 [▶]
//  "application" => array:5 [▶]
//  "credit_qualification" => array:5 [▶]
//  "post_load" => array:5 [▶]
//  "black_gray" => array:5 [▶]
//  "multi_info" => array:5 [▶]
//  "user_report_id" => 92
//]

//
//        array:11 [▼
//  "user_report_type_id" => 1
//  "user_id" => 6
//  "order_id" => 91
//  "anti_fraud" => array:5 [▶]
//  "report_data" => array:6 [▶]
//  "application" => array:5 [▶]
//  "credit_qualification" => array:5 [▶]
//  "post_load" => array:5 [▶]
//  "black_gray" => array:5 [▶]
//  "multi_info" => array:5 [▶]
//  "user_report_id" => 94
//]
//        dd($params);
//        array:11 [▼
//  "user_report_type_id" => 1
//  "user_id" => 6
//  "order_id" => 91
//  "anti_fraud" => array:5 [▶]
//  "report_data" => array:6 [▶]
//  "application" => array:5 [▶]
//  "credit_qualification" => array:5 [▶]
//  "post_load" => array:5 [▶]
//  "black_gray" => array:5 [▶]
//  "multi_info" => array:5 [▶]
//  "user_report_id" => 140
//]

        //        dd($apply);
//        array:5 [▼
//  "success" => true
//  "code" => "0000"
//  "msg" => "操作成功"
//  "data" => array:8 [▼
//    "trans_id" => "6a50f490-ecbb-11e8-9c98-00163e0ed28c"
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
//    "black_info_detail" => array:6 [▼
//      "mobile_name_in_blacklist" => false
//      "mobile_name_blacklist_updated_time" => ""
//      "idcard_name_in_blacklist" => false
//      "idcard_name_blacklist_updated_time" => ""
//      "black_types" => ""
//      "blacklist_record" => array:3 [▼
//        "overdue_count" => 0
//        "overdue_amount" => ""
//        "overdue_status" => ""
//      ]
//    ]
//    "gray_info_detail" => array:6 [▼
//      "mobile_name_in_gray" => false
//      "mobile_name_gray_updated_time" => ""
//      "idcard_name_in_gray" => false
//      "idcard_name_gray_updated_time" => ""
//      "gray_types" => ""
//      "graylist_record" => array:3 [▼
//        "overdue_count" => 0
//        "overdue_amount" => ""
//        "overdue_status" => ""
//      ]
//    ]
//    "mobile_info" => array:7 [▼
//      "match_score" => 100
//      "mobile_contact_30d" => array:14 [▼
//        "contactnum" => 0
//        "auth_contactnum" => 0
//        "auth_contact_ratio" => "0.00"
//        "black_contactnum" => 0
//        "black_contactnum_ratio" => "0.00"
//        "contact_type" => ""
//        "auth_indirectnum" => 0
//        "auth_indirectnum_ratio" => "0.00"
//        "black_indirectnum" => 0
//        "black_indirectnum_ratio" => "0.00"
//        "black_indirect_peernum" => 0
//        "black_indirect_peernum_ratio" => "0.00"
//        "auth_indirect_peernum" => 0
//        "auth_indirect_peernum_ratio" => "0.00"
//      ]
//      "intimate_contact_info_30d" => array:14 [▼
//        "intimatenum" => 0
//        "auth_intimatenum" => 0
//        "auth_intimatenum_ratio" => "0.00"
//        "black_intimatenum" => 0
//        "black_intimatenum_ratio" => "0.00"
//        "intimate_type" => ""
//        "auth_intimate_indirectnum" => 0
//        "auth_intimate_indirectnum_ratio" => "0.00"
//        "black_intimate_indirectnum" => 0
//        "black_intimate_indirectnum_ratio" => "0.00"
//        "black_intimate_indirect_peernum" => 0
//        "black_intimate_indirect_peernum_ratio" => "0.00"
//        "auth_intimate_indirect_peernum" => 0
//        "auth_intimate_indirect_peernum_ratio" => "0.00"
//      ]
//      "mobile_contact_90d" => array:14 [▼
//        "contactnum" => 0
//        "auth_contactnum" => 0
//        "auth_contact_ratio" => "0.00"
//        "black_contactnum" => 0
//        "black_contactnum_ratio" => "0.00"
//        "contact_type" => ""
//        "auth_indirectnum" => 0
//        "auth_indirectnum_ratio" => "0.00"
//        "black_indirectnum" => 0
//        "black_indirectnum_ratio" => "0.00"
//        "black_indirect_peernum" => 0
//        "black_indirect_peernum_ratio" => "0.00"
//        "auth_indirect_peernum" => 0
//        "auth_indirect_peernum_ratio" => "0.00"
//      ]
//      "intimate_contact_info_90d" => array:14 [▼
//        "intimatenum" => 0
//        "auth_intimatenum" => 0
//        "auth_intimatenum_ratio" => "0.00"
//        "black_intimatenum" => 0
//        "black_intimatenum_ratio" => "0.00"
//        "intimate_type" => ""
//        "auth_intimate_indirectnum" => 0
//        "auth_intimate_indirectnum_ratio" => "0.00"
//        "black_intimate_indirectnum" => 0
//        "black_intimate_indirectnum_ratio" => "0.00"
//        "black_intimate_indirect_peernum" => 0
//        "black_intimate_indirect_peernum_ratio" => "0.00"
//        "auth_intimate_indirect_peernum" => 0
//        "auth_intimate_indirect_peernum_ratio" => "0.00"
//      ]
//      "mobile_contact_180d" => array:14 [▼
//        "contactnum" => 0
//        "auth_contactnum" => 0
//        "auth_contact_ratio" => "0.00"
//        "black_contactnum" => 0
//        "black_contactnum_ratio" => "0.00"
//        "contact_type" => ""
//        "auth_indirectnum" => 0
//        "auth_indirectnum_ratio" => "0.00"
//        "black_indirectnum" => 0
//        "black_indirectnum_ratio" => "0.00"
//        "black_indirect_peernum" => 0
//        "black_indirect_peernum_ratio" => "0.00"
//        "auth_indirect_peernum" => 0
//        "auth_indirect_peernum_ratio" => "0.00"
//      ]
//      "intimate_contact_info_180d" => array:14 [▼
//        "intimatenum" => 0
//        "auth_intimatenum" => 0
//        "auth_intimatenum_ratio" => "0.00"
//        "black_intimatenum" => 0
//        "black_intimatenum_ratio" => "0.00"
//        "intimate_type" => ""
//        "auth_intimate_indirectnum" => 0
//        "auth_intimate_indirectnum_ratio" => "0.00"
//        "black_intimate_indirectnum" => 0
//        "black_intimate_indirectnum_ratio" => "0.00"
//        "black_intimate_indirect_peernum" => 0
//        "black_intimate_indirect_peernum_ratio" => "0.00"
//        "auth_intimate_indirect_peernum" => 0
//        "auth_intimate_indirect_peernum_ratio" => "0.00"
//      ]
//    ]
//    "auth_queried_detail" => array:6 [▼
//      "register_info" => array:3 [▼
//        "other_count" => 0
//        "org_count" => 0
//        "org_types" => []
//      ]
//      "queried_detail_org_count" => 0
//      "queried_analyze" => []
//      "queried_infos" => []
//      "loan_org_cnt_all" => 0
//      "loan_info" => array:10 [▼
//        "loan_org_cnt" => 0
//        "loan_cnt" => 0
//        "loan_org_cnt_15d" => 0
//        "loan_org_cnt_30d" => 0
//        "loan_org_cnt_90d" => 0
//        "loan_org_cnt_180d" => 0
//        "loan_cnt_15d" => 0
//        "loan_cnt_30d" => 0
//        "loan_cnt_90d" => 0
//        "loan_cnt_180d" => 0
//      ]
//    ]
//    "risk_device" => []
//    "credit_card" => array:13 [▼
//      "update_date" => ""
//      "bank_nums" => 0
//      "card_amount" => 0
//      "total_credit_limit" => ""
//      "max_credit_limit" => ""
//      "overdue_card" => 0
//      "bill_nums" => 0
//      "credit_overdue_item_12m" => array:2 [▼
//        "overdue_times" => 0
//        "overdue_months" => 0
//      ]
//      "credit_overdue_item_6m" => array:2 [▼
//        "overdue_times" => 0
//        "overdue_months" => 0
//      ]
//      "credit_overdue_item_3m" => array:2 [▼
//        "overdue_times" => 0
//        "overdue_months" => 0
//      ]
//      "last_overdue_date" => ""
//      "max_overdue_money" => ""
//      "continue_overdue_times" => 0
//    ]
//  ]
//  "fee" => "Y"
//]
        $data['user_id'] = $params['user_id'];//6
        $data['user_report_id'] = $params['user_report_id'];//1s
        $data['transid'] = $params['application']['data']['trans_id'];//1
//        $data['due_days_non_cdq_12_mon'] = 1;//1  todo::$params['due_days_non_cdq_12_mon']
//        $data['pay_cnt_12_mon'] = 1;//1  todo::$params['pay_cnt_12_mon']
//        $data['loan_behavior_analysis'] = '{"people":[{"firstName":"Brett","lastName":"McLaughlin","email":"aaaa"},{"firstName":"Jason","lastName":"Hunter","email":"bbbb"},{"firstName":"Elliotte","lastName":"Harold","email":"cccc"}]}';//$params['loan_behavior_analysis']
        $data['data'] = json_encode($params['application']['data']);//'{"people":[{"firstName":"Brett","lastName":"McLaughlin","email":"aaaa"},{"firstName":"Jason","lastName":"Hunter","email":"bbbb"},{"firstName":"Elliotte","lastName":"Harold","email":"cccc"}]}'
        $data['fee'] = $params['application']['fee'];//'Y'
        $data['create_at'] = date('Y-m-d H:i:s', time());
        $data['update_at'] = date('Y-m-d H:i:s', time());

//        dd($data);
//        array:7 [▼
//  "user_id" => 6
//  "user_report_id" => 137
//  "transid" => "e2481f00-ee28-11e8-9d68-00163e0d2aee"
//  "data" => "{"trans_id":"e2481f00-ee28-11e8-9d68-00163e0d2aee","person_info":{"idcard":"21092219891006****","idcard_location":"\u8fbd\u5b81\u7701\/\u961c\u65b0\u5e02\/\u5f7 ▶"
//  "fee" => "Y"
//  "create_at" => "2018-11-22 15:33:22"
//  "update_at" => "2018-11-22 15:33:22"
//]
        $userApply = UserOrderFactory::createApply($data);

//        $userId = $params['user_id'];
//        $orderType = $params['order_type'];
//        $userOrder = UserOrderFactory::getUserOrderByUserIdAndOrderType($userId, $orderType);
//
        if (!$userApply) {
            $this->error['error'] = "您好，报告记录关系异常！";
            return false;
        }
        return true;
    }
}
