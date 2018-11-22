<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Api\ApiController;
use App\Models\Factory\Api\UserAuthFactory;
use App\Models\Factory\Api\UserOrderFactory;
use App\Models\Factory\Api\UserRealnameFactory;
use App\Models\Factory\Api\UserReportFactory;
use App\Services\Core\Validator\Scorpion\Mozhang\MozhangService;
use App\Strategies\OrderStrategy;
use Illuminate\Http\Request;

class ReportCallbackController extends ApiController
{

    public function create(Request $request)
    {
        $userId = $this->getUserId($request);
        $userRealName = UserRealnameFactory::fetchUserRealname($userId);
        $token = ($request->input('token') ?: $request->header('X-Token')) ?: '';
        $userAuth = UserAuthFactory::getUserAuthByAccessToken($token);
        $orderNo = $request->input('order_no');
        $userOrder = UserOrderFactory::getUserOrderByOrderNo($orderNo);

        $reportTypeNid = $request->input('report_type_nid');
        $reportType = UserReportFactory::getReportTypeByTypeNid($reportTypeNid);

        //todo::
        $res = [];
        $res['user_report_type_id'] = $reportType['id'];
        $res['user_id'] = $userId;
        $res['order_id'] = $userOrder['id'];

        //反欺诈
//        $antiFraud = MozhangService::o()->getMoZhangContent($userRealName['real_name'], $userRealName['id_card_no'], $userAuth['mobile'], 'anti-fraud');
        $antiFraud = [
            "success" => 1,
            "code" => "0000",
            "msg" => "操作成功",
            "data" => [
                "trans_id" => "3502f4f0-ee0a-11e8-9d68-00163e0d2aee",
                "person_info" => [
                    "idcard" => "61030319791111****",
                    "idcard_location" => "陕西省/宝鸡市/金台区",
                    "mobile" => "1381056****",
                    "carrier" => "中国移动",
                    "mobile_location" => "北京/北京",
                    "name" => "巨*",
                    "age" => 39,
                    "gender" => "男",
                    "email" => "",
                    "education_info" => [
                        "level" => 0,
                        "is_graduation" => false
                    ]
                ],
                "untrusted_info" => [
                    "courtcase_cnt" => 0,
                    "dishonest_cnt" => 0,
                    "dishonest_detail_info" => []
                ],
                "suspicious_idcard" => [
                    "other_names_cnt" => 0,
                    "other_mobiles_cnt" => 0,
                    "other_mobiles_black_cnt" => 0,
                    "information_sources_cnt" => 0,
                    "other_names" => [],
                    "other_mobiles" => [],
                    "information_sources" => []
                ],
                "suspicious_mobile" => [
                    "other_names_cnt" => 0,
                    "other_idcards_cnt" => 0,
                    "other_idcards_black_cnt" => 0,
                    "information_sources_cnt" => 0,
                    "other_names" => [],
                    "other_idcards" => [],
                    "information_sources" => []
                ],
                "suspicious_device" => [
                    "other_devices_cnt" => 1,
                    "mobile_other_devices_cnt" => 0,
                    "idcard_other_devices_cnt" => 1,
                    "information_sources_cnt" => 1,
                    "other_names_cnt" => 1,
                    "other_mobiles_cnt" => 0,
                    "other_mobiles_black_cnt" => 0,
                    "other_idcards_cnt" => 0,
                    "other_idcards_black_cnt" => 0,
                    "other_names" => [
                        0 => [
                            "latest_used_time" => "2018-07-05 10:00:02",
                            "name" => "巨*"
                        ]
                    ],
                    "other_mobiles" => [],
                    "other_idcards" => [],
                    "information_sources" => [
                        0 => [
                            "latest_used_time" => "2018-07-05 10:00:02",
                            "org_type" => "其它"
                        ]
                    ]
                ],
                "risk_qqgroup" => [
                    "loan_groupcnt" => 0,
                    "installment_groupcnt" => 0,
                    "financial_management_groupcnt" => 0,
                    "woolen_groupcnt" => 0,
                    "gambling_groupcnt" => 0
                ],
                "fraudulence_info" => [
                    "is_hit" => false,
                    "type" => ""
                ]
            ],
            "fee" => "Y"
        ];
        $res['anti_fraud'] = $antiFraud;
        $res['report_data']['anti_fraud'] = $antiFraud['data'];

//        dd($antiFraud);
//        array:5 [▼
//  "success" => true
//  "code" => "0000"
//  "msg" => "操作成功"
//  "data" => array:8 [▼
//    "trans_id" => "edf92610-ec74-11e8-bea7-00163e0d2aee"
//    "person_info" => array:10 [▼
//      "idcard" => "61030319791111****"
//      "idcard_location" => "陕西省/宝鸡市/金台区"
//      "mobile" => "1381056****"
//      "carrier" => "中国移动"
//      "mobile_location" => "北京/北京"
//      "name" => "巨*"
//      "age" => 39
//      "gender" => "男"
//      "email" => ""
//      "education_info" => array:2 [▼
//        "level" => 0
//        "is_graduation" => false
//      ]
//    ]
//    "untrusted_info" => array:3 [▼
//      "courtcase_cnt" => 0
//      "dishonest_cnt" => 0
//      "dishonest_detail_info" => []
//    ]
//    "suspicious_idcard" => array:7 [▼
//      "other_names_cnt" => 0
//      "other_mobiles_cnt" => 0
//      "other_mobiles_black_cnt" => 0
//      "information_sources_cnt" => 0
//      "other_names" => []
//      "other_mobiles" => []
//      "information_sources" => []
//    ]
//    "suspicious_mobile" => array:7 [▼
//      "other_names_cnt" => 0
//      "other_idcards_cnt" => 0
//      "other_idcards_black_cnt" => 0
//      "information_sources_cnt" => 0
//      "other_names" => []
//      "other_idcards" => []
//      "information_sources" => []
//    ]
//    "suspicious_device" => array:13 [▼
//      "other_devices_cnt" => 1
//      "mobile_other_devices_cnt" => 0
//      "idcard_other_devices_cnt" => 1
//      "information_sources_cnt" => 1
//      "other_names_cnt" => 0
//      "other_mobiles_cnt" => 0
//      "other_mobiles_black_cnt" => 0
//      "other_idcards_cnt" => 0
//      "other_idcards_black_cnt" => 0
//      "other_names" => []
//      "other_mobiles" => []
//      "other_idcards" => []
//      "information_sources" => array:1 [▼
//        0 => array:2 [▼
//          "latest_used_time" => "2018-07-05 10:00:02"
//          "org_type" => "其它"
//        ]
//      ]
//    ]
//    "risk_qqgroup" => array:5 [▼
//      "loan_groupcnt" => 0
//      "installment_groupcnt" => 0
//      "financial_management_groupcnt" => 0
//      "woolen_groupcnt" => 0
//      "gambling_groupcnt" => 0
//    ]
//    "fraudulence_info" => array:2 [▼
//      "is_hit" => false
//      "type" => ""
//    ]
//  ]
//  "fee" => "Y"
//]


//申请准入
//        $apply = MozhangService::o()->getMoZhangContent($userRealName['real_name'], $userRealName['id_card_no'], $userAuth['mobile'], 'application');
        $apply = [
            "success" => true,
            "code" => "0000",
            "msg" => "操作成功",
            "data" => [
                "trans_id" => "60762800-ee0a-11e8-9d68-00163e0d2aee",
                "person_info" => [
                    "idcard" => "61030319791111****",
                    "idcard_location" => "陕西省/宝鸡市/金台区",
                    "mobile" => "1381056****",
                    "carrier" => "中国移动",
                    "mobile_location" => "北京/北京",
                    "name" => "巨*",
                    "age" => 39,
                    "gender" => "男",
                    "email" => "",
                    "education_info" => [
                        "level" => 0,
                        "is_graduation" => false
                    ]
                ],
                "black_info_detail" => [
                    "mobile_name_in_blacklist" => false,
                    "mobile_name_blacklist_updated_time" => "",
                    "idcard_name_in_blacklist" => false,
                    "idcard_name_blacklist_updated_time" => "",
                    "black_types" => "",
                    "blacklist_record" => [
                        "overdue_count" => 0,
                        "overdue_amount" => "",
                        "overdue_status" => ""
                    ]
                ],
                "gray_info_detail" => [
                    "mobile_name_in_gray" => false,
                    "mobile_name_gray_updated_time" => "",
                    "idcard_name_in_gray" => false,
                    "idcard_name_gray_updated_time" => "",
                    "gray_types" => "",
                    "graylist_record" => [
                        "overdue_count" => 0,
                        "overdue_amount" => "",
                        "overdue_status" => ""
                    ]
                ],
                "mobile_info" => [
                    "match_score" => 100,
                    "mobile_contact_30d" => [
                        "contactnum" => 0,
                        "auth_contactnum" => 0,
                        "auth_contact_ratio" => "0.00",
                        "black_contactnum" => 0,
                        "black_contactnum_ratio" => "0.00",
                        "contact_type" => "",
                        "auth_indirectnum" => 0,
                        "auth_indirectnum_ratio" => "0.00",
                        "black_indirectnum" => 0,
                        "black_indirectnum_ratio" => "0.00",
                        "black_indirect_peernum" => 0,
                        "black_indirect_peernum_ratio" => "0.00",
                        "auth_indirect_peernum" => 0,
                        "auth_indirect_peernum_ratio" => "0.00"
                    ],
                    "intimate_contact_info_30d" => [
                        "intimatenum" => 0,
                        "auth_intimatenum" => 0,
                        "auth_intimatenum_ratio" => "0.00",
                        "black_intimatenum" => 0,
                        "black_intimatenum_ratio" => "0.00",
                        "intimate_type" => "",
                        "auth_intimate_indirectnum" => 0,
                        "auth_intimate_indirectnum_ratio" => "0.00",
                        "black_intimate_indirectnum" => 0,
                        "black_intimate_indirectnum_ratio" => "0.00",
                        "black_intimate_indirect_peernum" => 0,
                        "black_intimate_indirect_peernum_ratio" => "0.00",
                        "auth_intimate_indirect_peernum" => 0,
                        "auth_intimate_indirect_peernum_ratio" => "0.00"
                    ],
                    "mobile_contact_90d" => [
                        "contactnum" => 0,
                        "auth_contactnum" => 0,
                        "auth_contact_ratio" => "0.00",
                        "black_contactnum" => 0,
                        "black_contactnum_ratio" => "0.00",
                        "contact_type" => "",
                        "auth_indirectnum" => 0,
                        "auth_indirectnum_ratio" => "0.00",
                        "black_indirectnum" => 0,
                        "black_indirectnum_ratio" => "0.00",
                        "black_indirect_peernum" => 0,
                        "black_indirect_peernum_ratio" => "0.00",
                        "auth_indirect_peernum" => 0,
                        "auth_indirect_peernum_ratio" => "0.00"
                    ],
                    "intimate_contact_info_90d" => [
                        "intimatenum" => 0,
                        "auth_intimatenum" => 0,
                        "auth_intimatenum_ratio" => "0.00",
                        "black_intimatenum" => 0,
                        "black_intimatenum_ratio" => "0.00",
                        "intimate_type" => "",
                        "auth_intimate_indirectnum" => 0,
                        "auth_intimate_indirectnum_ratio" => "0.00",
                        "black_intimate_indirectnum" => 0,
                        "black_intimate_indirectnum_ratio" => "0.00",
                        "black_intimate_indirect_peernum" => 0,
                        "black_intimate_indirect_peernum_ratio" => "0.00",
                        "auth_intimate_indirect_peernum" => 0,
                        "auth_intimate_indirect_peernum_ratio" => "0.00"
                    ],
                    "mobile_contact_180d" => [
                        "contactnum" => 0,
                        "auth_contactnum" => 0,
                        "auth_contact_ratio" => "0.00",
                        "black_contactnum" => 0,
                        "black_contactnum_ratio" => "0.00",
                        "contact_type" => "",
                        "auth_indirectnum" => 0,
                        "auth_indirectnum_ratio" => "0.00",
                        "black_indirectnum" => 0,
                        "black_indirectnum_ratio" => "0.00",
                        "black_indirect_peernum" => 0,
                        "black_indirect_peernum_ratio" => "0.00",
                        "auth_indirect_peernum" => 0,
                        "auth_indirect_peernum_ratio" => "0.00"
                    ],
                    "intimate_contact_info_180d" => [
                        "intimatenum" => 0,
                        "auth_intimatenum" => 0,
                        "auth_intimatenum_ratio" => "0.00",
                        "black_intimatenum" => 0,
                        "black_intimatenum_ratio" => "0.00",
                        "intimate_type" => "",
                        "auth_intimate_indirectnum" => 0,
                        "auth_intimate_indirectnum_ratio" => "0.00",
                        "black_intimate_indirectnum" => 0,
                        "black_intimate_indirectnum_ratio" => "0.00",
                        "black_intimate_indirect_peernum" => 0,
                        "black_intimate_indirect_peernum_ratio" => "0.00",
                        "auth_intimate_indirect_peernum" => 0,
                        "auth_intimate_indirect_peernum_ratio" => "0.00"
                    ]
                ],
                "auth_queried_detail" => [
                    "register_info" => [
                        "other_count" => 0,
                        "org_count" => 1,
                        "org_types" => [
                            0 => "DATACOVERGE"
                        ]
                    ],
                    "queried_detail_org_count" => 1,
                    "queried_analyze" => [
                        0 => [
                            "org_type" => "DATACOVERGE",
                            "loan_cnt_15d" => 0,
                            "loan_cnt_30d" => 0,
                            "loan_cnt_90d" => 1,
                            "loan_cnt_180d" => 1,
                        ]
                    ],
                    "queried_infos" => [
                        0 => [
                            "date" => "2018-09-07",
                            "org_type" => "DATACOVERGE",
                            "is_self" => false
                        ]
                    ],
                    "loan_org_cnt_all" => 0,
                    "loan_info" => [
                        "loan_org_cnt" => 0,
                        "loan_cnt" => 0,
                        "loan_org_cnt_15d" => 0,
                        "loan_org_cnt_30d" => 0,
                        "loan_org_cnt_90d" => 0,
                        "loan_org_cnt_180d" => 0,
                        "loan_cnt_15d" => 0,
                        "loan_cnt_30d" => 0,
                        "loan_cnt_90d" => 0,
                        "loan_cnt_180d" => 0
                    ]
                ],
                "risk_device" => [],
                "credit_card" => [
                    "update_date" => "",
                    "bank_nums" => 0,
                    "card_amount" => 0,
                    "total_credit_limit" => "",
                    "max_credit_limit" => "",
                    "overdue_card" => 0,
                    "bill_nums" => 0,
                    "credit_overdue_item_12m" => [
                        "overdue_times" => 0,
                        "overdue_months" => 0
                    ],
                    "credit_overdue_item_6m" => [
                        "overdue_times" => 0,
                        "overdue_months" => 0
                    ],
                    "credit_overdue_item_3m" => [
                        "overdue_times" => 0,
                        "overdue_months" => 0
                    ],
                    "last_overdue_date" => "",
                    "max_overdue_money" => "",
                    "continue_overdue_times" => 0
                ],
            ],
            "fee" => "Y"
        ];
//
////        dd($apply);
        $res['application'] = $apply;
        $res['report_data']['application'] = $apply['data'];


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


//额度评估(电商)
//        $credidtQualification = MozhangService::o()->getMoZhangContent($userRealName['real_name'], $userRealName['id_card_no'], $userAuth['mobile'], 'credit.qualification');
        $credidtQualification = [
            "success" => true,
            "code" => "0000",
            "msg" => "操作成功",
            "data" => [
                "trans_id" => "86d304a0-ee0a-11e8-9d68-00163e0d2aee",
                "person_info" => [
                    "idcard" => "61030319791111****",
                    "idcard_location" => "陕西省/宝鸡市/金台区",
                    "mobile" => "1381056****",
                    "carrier" => "中国移动",
                    "mobile_location" => "北京/北京",
                    "name" => "巨*",
                    "age" => 39,
                    "gender" => "男",
                    "email" => "",
                    "education_info" => [
                        "level" => 0,
                        "is_graduation" => false
                    ]
                ],
                "qualification_info" => [
                    "zm_score_info" => [
                        "last_modify_time" => "",
                        "zm_score" => ""
                    ],
                    "huabei_info" => [
                        "last_modify_time" => "",
                        "huabai_limit" => ""
                    ],
                    "jiebei_info" => [
                        "last_modify_time" => "",
                        "credit_amt" => ""
                    ]
                ]
            ],
            "fee" => "N"
        ];
//
////        dd($credidtQualification);
        $res['credit_qualification'] = $credidtQualification;
        $res['report_data']['credit_qualification'] = $credidtQualification['data'];


//        array:5 [▼
//  "success" => true
//  "code" => "0000"
//  "msg" => "操作成功"
//  "data" => array:3 [▼
//    "trans_id" => "d07e1210-ecbc-11e8-bea7-00163e0d2aee"
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
//    "qualification_info" => array:3 [▼
//      "zm_score_info" => array:2 [▼
//        "last_modify_time" => ""
//        "zm_score" => ""
//      ]
//      "huabei_info" => array:2 [▼
//        "last_modify_time" => ""
//        "huabai_limit" => ""
//      ]
//      "jiebei_info" => array:2 [▼
//        "last_modify_time" => ""
//        "credit_amt" => ""
//      ]
//    ]
//  ]
//  "fee" => "N"
//]
//


//贷后行为
//        $postLoad = MozhangService::o()->getMoZhangContent($userRealName['real_name'], $userRealName['id_card_no'], $userAuth['mobile'], 'post-load');
        $postLoad = [
            "success" => true,
            "code" => "0000",
            "msg" => "操作成功",
            "data" => [
                "trans_id" => "dbc514d0-ee0a-11e8-a3bc-00163e0ed28c",
                "person_info" => [
                    "idcard" => "61030319791111****",
                    "idcard_location" => "陕西省/宝鸡市/金台区",
                    "mobile" => "1381056****",
                    "carrier" => "中国移动",
                    "mobile_location" => "北京/北京",
                    "name" => "巨*",
                    "age" => 39,
                    "gender" => "男",
                    "email" => "",
                    "education_info" => [
                        "level" => 0,
                        "is_graduation" => false
                    ]
                ],
                "loan_behavior_analysis" => [
                    "defaultday_from_first_to_end" => "",
                    "feature_7d" => [
                        "jiedai4_sum_fail_cnt_d7" => "",
                        "jiedai_avg_defaultdays_d7" => "",
                        "jiedai4_count_fill_d3_cnt_d7" => "",
                        "jiedai_max_defaultdays_d7" => "",
                        "dd_jiedai_sum_fill_d5_cnt_d7" => "",
                        "dd_jiedai_count_fail_mamberadd_d7" => "",
                        "dd_jiedai_avg_fail_days1_d7" => "",
                        "jiedai_min_defaultdays_d7" => "",
                        "last_to_end_sure_due_all_pro_all_time_d7" => "",
                        "max_sure_due_days_non_cdq_all_time_d7" => "",
                        "sum_sure_due_days_all_pro_all_time_d7" => "",
                        "last_to_end_sure_due_non_cdq_all_time_d7" => ""
                    ],
                    "feature_15d" => [
                        "jiedai_avg_defaultdays_d15" => "",
                        "jiedai_min_defaultdays_d15" => "",
                        "jiedai4_sum_fail_cnt_d15" => "",
                        "dd_jiedai_avg_fail_days1_d15" => "",
                        "jiedai4_count_fill_d3_cnt_d15" => "",
                        "jiedai4_count_fill_d5_cnt_d15" => "",
                        "dd_jiedai_count_fail_mamberadd_d15" => "",
                        "jiedai_sum_fail_amt_d15" => "",
                        "dd_jiedai_max_fail_days1_d15" => "",
                        "sum_sure_due_days_all_pro_all_time_d15" => "",
                        "last_to_end_sure_due_all_pro_all_time_d15" => "",
                        "max_sure_due_days_non_cdq_all_time_d15" => "",
                        "last_to_end_sure_due_non_cdq_all_time_d15" => ""
                    ],
                    "feature_30d" => [
                        "jiedai_avg_defaultdays_m1" => "",
                        "dd_jiedai_max_fail_days1_m1" => "",
                        "jiedai4_sum_fail_cnt1" => "",
                        "dd_jiedai_max_fail_days_m1" => "",
                        "dd_jiedai_count_fail_mamberadd_m1" => "",
                        "jiedai4_count_fill_d3_cnt_m1" => "",
                        "dd_jiedai_min_fail_days1_m1" => "",
                        "jiedai_sum_fail_amt1" => "",
                        "cdq_dd_jiedai_max_fail_days1_m1" => "",
                        "jiedai4_count_fill_d5_cnt_m1" => "",
                        "jiedai4_avg_succ_amt1" => "",
                        "sum_sure_due_days_non_cdq_all_time_m1" => "",
                        "sum_sure_due_days_all_pro_all_time_m1" => "",
                        "avg_sure_due_days_non_cdq_all_time_m1" => "",
                        "pct_pay_amt_cdq_pro_all_time_m1" => "",
                        "max_pay_amt_all_pro_all_time_m1" => ""
                    ],
                    "feature_90d" => [
                        "jiedai_avg_defaultdays_m3" => "",
                        "dd_jiedai_max_fail_days1_m3" => "",
                        "dd_jiedai_avg_fail_days_m3" => "",
                        "dd_jiedai_count_fail_mamberadd_m3" => "",
                        "jiedai4_count_fill_d3_cnt_m3" => "",
                        "jiedai4_count_fill_d5_cnt_m3" => "",
                        "cdq_dd_jiedai_avg_fail_days1_m3" => "",
                        "jiedai4_avg_succ_amt3" => "",
                        "jiedai_sum_fail_amt3" => "",
                        "dd_jiedai_min_fail_days1_m3" => "",
                        "sum_sure_due_days_all_pro_all_time_m3" => "",
                        "sum_sure_due_days_non_cdq_all_time_m3" => "",
                        "avg_sure_due_days_all_pro_all_time_m3" => "",
                        "max_due_cnt_non_cdq_all_time_m3" => "",
                        "avg_sure_due_days_non_cdq_all_time_m3" => "",
                        "pct_pay_amt_cdq_pro_all_time_m3" => ""
                    ],
                    "feature_180d" => [
                        "jiedai_avg_defaultdays_m6" => "",
                        "dd_jiedai_avg_fail_days1_m6" => "",
                        "dd_jiedai_avg_fail_days_m6" => "",
                        "dd_jiedai_count_fail_mamberadd_m6" => "",
                        "jiedai4_count_fill_d3_cnt_m6" => "",
                        "cdq_dd_jiedai_avg_fail_days1_m6" => "",
                        "cdq_dd_jiedai_max_fail_days1_m6" => "",
                        "jiedai4_avg_succ_amt6" => "",
                        "jiedai4_count_fill_d5_cnt_m6" => "",
                        "sum_sure_due_days_non_cdq_all_time_m6" => "",
                        "max_sure_due_days_all_pro_all_time_m6" => "",
                        "avg_sure_due_days_all_pro_all_time_m6" => "",
                        "avg_sure_due_days_non_cdq_all_time_m6" => "",
                        "pct_pay_amt_cdq_pro_all_time_m6" => ""
                    ],
                    "feature_360d" => [
                        "dd_jiedai_max_fail_days_m12" => "",
                        "dd_jiedai_sum_fill_d5_cnt_m12" => "",
                        "last_to_end_sure_due_all_pro_all_time_m12" => "",
                        "sum_sure_due_days_non_cdq_all_time_m12" => "",
                        "last_to_end_sure_due_non_cdq_all_time_m12" => "",
                        "max_due_cnt_all_pro_all_time_m12" => "",
                        "max_due_cnt_non_cdq_all_time_m12" => "",
                        "max_pay_amt_all_pro_all_time_m12" => "",
                        "sum_pay_cnt_all_pro_all_time_m12" => ""
                    ]
                ]
            ],
            "fee" => "N"
        ];
//
////        dd($postLoad);
        $res['post_load'] = $postLoad;
        $res['report_data']['post_load'] = $postLoad['data'];

//
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


        //黑灰名单
//        $blackGray = MozhangService::o()->getMoZhangContent($userRealName['real_name'], $userRealName['id_card_no'], $userAuth['mobile'], 'black-gray');
        $blackGray = [
            "success" => true,
            "code" => "0000",
            "msg" => "操作成功",
            "data" => [
                "trans_id" => "601258f0-ee11-11e8-a3bc-00163e0ed28c",
                "person_info" => [
                    "idcard" => "61030319791111****",
                    "idcard_location" => "陕西省/宝鸡市/金台区",
                    "mobile" => "1381056****",
                    "carrier" => "中国移动",
                    "mobile_location" => "北京/北京",
                    "name" => "巨*",
                    "age" => 39,
                    "gender" => "男",
                    "email" => "",
                    "education_info" => [
                        "level" => 0,
                        "is_graduation" => false
                    ]
                ],
                "black_info_detail" => [
                    "mobile_name_in_blacklist" => false,
                    "mobile_name_blacklist_updated_time" => "",
                    "idcard_name_in_blacklist" => false,
                    "idcard_name_blacklist_updated_time" => "",
                    "black_types" => "",
                    "blacklist_record" => [
                        "overdue_count" => 0,
                        "overdue_amount" => "",
                        "overdue_status" => ""
                    ]
                ],
                "gray_info_detail" => [
                    "mobile_name_in_gray" => false,
                    "mobile_name_gray_updated_time" => "",
                    "idcard_name_in_gray" => false,
                    "idcard_name_gray_updated_time" => "",
                    "gray_types" => "",
                    "graylist_record" => [
                        "overdue_count" => 0,
                        "overdue_amount" => "",
                        "overdue_status" => ""
                    ]
                ]
            ],
            "fee" => "Y"
        ];
//
////        dd($blackGray);
        $res['black_gray'] = $blackGray;
        $res['report_data']['black_gray'] = $blackGray['data'];
//        dd($blackGray);
//
//        array:5 [▼
//  "success" => true
//  "code" => "0000"
//  "msg" => "操作成功"
//  "data" => array:4 [▼
//    "trans_id" => "09317e20-ecbe-11e8-bea7-00163e0d2aee"
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
//  ]
//  "fee" => "Y"
//]
//


        //多头报告
//        $multiinfo = MozhangService::o()->getMoZhangContent($userRealName['real_name'], $userRealName['id_card_no'], $userAuth['mobile'], 'multi-info');
        $multiinfo = [
  "success" => true,
  "code" => "0000",
  "msg" => "操作成功",
  "data" => [
    "trans_id" => "93d5d7c0-ee11-11e8-a3bc-00163e0ed28c",
    "person_info" => [
      "idcard" => "61030319791111****",
      "idcard_location" => "陕西省/宝鸡市/金台区",
      "mobile" => "1381056****",
      "carrier" => "中国移动",
      "mobile_location" => "北京/北京",
      "name" => "巨*",
      "age" => 39,
      "gender" => "男",
      "email" => "",
      "education_info" => [
        "level" => 0,
        "is_graduation" => false
      ]
    ],
    "auth_queried_detail" => [
      "register_info" => [
        "other_count" => 0,
        "org_count" => 1,
        "org_types" => [
          0 => "DATACOVERGE"
        ]
      ],
      "queried_detail_org_count" => 1,
      "queried_analyze" => [
        0 => [
          "org_type" => "DATACOVERGE",
          "loan_cnt_15d" => 0,
          "loan_cnt_30d" => 0,
          "loan_cnt_90d" => 1,
          "loan_cnt_180d" => 1
        ]
      ],
      "queried_infos" => [
        0 => [
          "date" => "2018-09-07",
          "org_type" => "DATACOVERGE",
          "is_self" => false
        ]
      ],
      "loan_org_cnt_all" => 0,
      "loan_info" => [
        "loan_org_cnt" => 0,
        "loan_cnt" => 0,
        "loan_org_cnt_15d" => 0,
        "loan_org_cnt_30d" => 0,
        "loan_org_cnt_90d" => 0,
        "loan_org_cnt_180d" => 0,
        "loan_cnt_15d" => 0,
        "loan_cnt_30d" => 0,
        "loan_cnt_90d" => 0,
        "loan_cnt_180d" => 0
      ]
    ]
  ],
  "fee" => "Y"
];
//        dd($multiinfo);
        $res['multi_info'] = $multiinfo;
        $res['report_data']['multi_info'] = $multiinfo['data'];


//        dd($multiinfo);
//        array:5 [▼
//  "success" => true
//  "code" => "0000"
//  "msg" => "操作成功"
//  "data" => array:3 [▼
//    "trans_id" => "871f0aa0-ecbe-11e8-bea7-00163e0d2aee"
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
//  ]
//  "fee" => "Y"
//]
//

        OrderStrategy::reportBak($res);
    }
}