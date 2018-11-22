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
        $antiFraud = MozhangService::o()->getMoZhangContent($userRealName['real_name'], $userRealName['id_card_no'], $userAuth['mobile'], 'anti-fraud');

        $res['anti_fraud'] = $antiFraud;
        $res['report_data']['anti_fraud'] = $antiFraud['data'];


//申请准入
        $apply = MozhangService::o()->getMoZhangContent($userRealName['real_name'], $userRealName['id_card_no'], $userAuth['mobile'], 'application');

        $res['application'] = $apply;
        $res['report_data']['application'] = $apply['data'];


//额度评估(电商)
        $credidtQualification = MozhangService::o()->getMoZhangContent($userRealName['real_name'], $userRealName['id_card_no'], $userAuth['mobile'], 'credit.qualification');

        $res['credit_qualification'] = $credidtQualification;
        $res['report_data']['credit_qualification'] = $credidtQualification['data'];

//贷后行为
        $postLoad = MozhangService::o()->getMoZhangContent($userRealName['real_name'], $userRealName['id_card_no'], $userAuth['mobile'], 'post-load');

        $res['post_load'] = $postLoad;
        $res['report_data']['post_load'] = $postLoad['data'];


        //黑灰名单
        $blackGray = MozhangService::o()->getMoZhangContent($userRealName['real_name'], $userRealName['id_card_no'], $userAuth['mobile'], 'black-gray');

        $res['black_gray'] = $blackGray;
        $res['report_data']['black_gray'] = $blackGray['data'];

        //多头报告
        $multiinfo = MozhangService::o()->getMoZhangContent($userRealName['real_name'], $userRealName['id_card_no'], $userAuth['mobile'], 'multi-info');

        $res['multi_info'] = $multiinfo;
        $res['report_data']['multi_info'] = $multiinfo['data'];
//        dd($res);
//        $res = [
//  "user_report_type_id" => 1,
//  "user_id" => 6,
//  "order_id" => 91,
//  "anti_fraud" => [
//    "success" => true,
//    "code" => "0000",
//    "msg" => "操作成功",
//    "data" => [
//      "trans_id" => "749c4bb0-ee29-11e8-9d68-00163e0d2aee",
//      "person_info" => [
//        "idcard" => "13070219811107****",
//        "idcard_location" => "河北省/张家口市/桥东区",
//        "mobile" => "1381056****",
//        "carrier" => "中国移动",
//        "mobile_location" => "北京/北京",
//        "name" => "蔡*",
//        "age" => 37,
//        "gender" => "男",
//        "email" => "",
//        "education_info" => [
//          "level" => 0,
//          "is_graduation" => false
//        ]
//      ],
//      "untrusted_info" => [
//        "courtcase_cnt" => 0,
//        "dishonest_cnt" => 0,
//        "dishonest_detail_info" => []
//      ],
//      "suspicious_idcard" => [
//        "other_names_cnt" => 0,
//        "other_mobiles_cnt" => 0,
//        "other_mobiles_black_cnt" => 0,
//        "information_sources_cnt" => 0,
//        "other_names" => [],
//        "other_mobiles" => [],
//        "information_sources" => []
//      ],
//      "suspicious_mobile" => [
//        "other_names_cnt" => 0,
//        "other_idcards_cnt" => 0,
//        "other_idcards_black_cnt" => 0,
//        "information_sources_cnt" => 0,
//        "other_names" => [],
//        "other_idcards" => [],
//        "information_sources" => []
//      ],
//      "suspicious_device" => [
//        "other_devices_cnt" => 0,
//        "mobile_other_devices_cnt" => 0,
//        "idcard_other_devices_cnt" => 0,
//        "information_sources_cnt" => 0,
//        "other_names_cnt" => 0,
//        "other_mobiles_cnt" => 0,
//        "other_mobiles_black_cnt" => 0,
//        "other_idcards_cnt" => 0,
//        "other_idcards_black_cnt" => 0,
//        "other_names" => [],
//        "other_mobiles" => [],
//        "other_idcards" => [],
//        "information_sources" => []
//      ],
//      "risk_qqgroup" => [
//        "loan_groupcnt" => 0,
//        "installment_groupcnt" => 0,
//        "financial_management_groupcnt" => 0,
//        "woolen_groupcnt" => 0,
//        "gambling_groupcnt" => 0
//      ],
//      "fraudulence_info" => [
//        "is_hit" => false,
//        "type" => ""
//      ]
//    ],
//    "fee" => "N"
//  ],
//  "report_data" => [
//    "anti_fraud" => [
//      "trans_id" => "749c4bb0-ee29-11e8-9d68-00163e0d2aee",
//      "person_info" => [
//        "idcard" => "13070219811107****",
//        "idcard_location" => "河北省/张家口市/桥东区",
//        "mobile" => "1381056****",
//        "carrier" => "中国移动",
//        "mobile_location" => "北京/北京",
//        "name" => "蔡*",
//        "age" => 37,
//        "gender" => "男",
//        "email" => "",
//        "education_info" => [
//          "level" => 0,
//          "is_graduation" => false
//        ]
//      ],
//      "untrusted_info" => [
//        "courtcase_cnt" => 0,
//        "dishonest_cnt" => 0,
//        "dishonest_detail_info" => []
//      ],
//      "suspicious_idcard" =>  [
//        "other_names_cnt" => 0,
//        "other_mobiles_cnt" => 0,
//        "other_mobiles_black_cnt" => 0,
//        "information_sources_cnt" => 0,
//        "other_names" => [],
//        "other_mobiles" => [],
//        "information_sources" => []
//      ],
//      "suspicious_mobile" => [
//        "other_names_cnt" => 0,
//        "other_idcards_cnt" => 0,
//        "other_idcards_black_cnt" => 0,
//        "information_sources_cnt" => 0,
//        "other_names" => [],
//        "other_idcards" => [],
//        "information_sources" => []
//      ],
//      "suspicious_device" => [
//        "other_devices_cnt" => 0,
//        "mobile_other_devices_cnt" => 0,
//        "idcard_other_devices_cnt" => 0,
//        "information_sources_cnt" => 0,
//        "other_names_cnt" => 0,
//        "other_mobiles_cnt" => 0,
//        "other_mobiles_black_cnt" => 0,
//        "other_idcards_cnt" => 0,
//        "other_idcards_black_cnt" => 0,
//        "other_names" => [],
//        "other_mobiles" => [],
//        "other_idcards" => [],
//        "information_sources" => []
//      ],
//      "risk_qqgroup" => [
//        "loan_groupcnt" => 0,
//        "installment_groupcnt" => 0,
//        "financial_management_groupcnt" => 0,
//        "woolen_groupcnt" => 0,
//        "gambling_groupcnt" => 0
//      ],
//      "fraudulence_info" => [
//        "is_hit" => false,
//        "type" => ""
//      ]
//    ],
//    "application" => [
//      "trans_id" => "74b10c30-ee29-11e8-a3bc-00163e0ed28c",
//      "person_info" => [
//        "idcard" => "13070219811107****",
//        "idcard_location" => "河北省/张家口市/桥东区",
//        "mobile" => "1381056****",
//        "carrier" => "中国移动",
//        "mobile_location" => "北京/北京",
//        "name" => "蔡*",
//        "age" => 37,
//        "gender" => "男",
//        "email" => "",
//        "education_info" => [
//          "level" => 0,
//          "is_graduation" => false
//        ]
//      ],
//      "black_info_detail" => [
//        "mobile_name_in_blacklist" => false,
//        "mobile_name_blacklist_updated_time" => "",
//        "idcard_name_in_blacklist" => false,
//        "idcard_name_blacklist_updated_time" => "",
//        "black_types" => "",
//        "blacklist_record" => [
//          "overdue_count" => 0,
//          "overdue_amount" => "",
//          "overdue_status" => ""
//        ]
//      ],
//      "gray_info_detail" => [
//        "mobile_name_in_gray" => false,
//        "mobile_name_gray_updated_time" => "",
//        "idcard_name_in_gray" => false,
//        "idcard_name_gray_updated_time" => "",
//        "gray_types" => "",
//        "graylist_record" => [
//          "overdue_count" => 0,
//          "overdue_amount" => "",
//          "overdue_status" => ""
//        ]
//      ],
//      "mobile_info" => [
//        "match_score" => 100,
//        "mobile_contact_30d" => [
//          "contactnum" => 0,
//          "auth_contactnum" => 0,
//          "auth_contact_ratio" => "0.00",
//          "black_contactnum" => 0,
//          "black_contactnum_ratio" => "0.00",
//          "contact_type" => "",
//          "auth_indirectnum" => 0,
//          "auth_indirectnum_ratio" => "0.00",
//          "black_indirectnum" => 0,
//          "black_indirectnum_ratio" => "0.00",
//          "black_indirect_peernum" => 0,
//          "black_indirect_peernum_ratio" => "0.00",
//          "auth_indirect_peernum" => 0,
//          "auth_indirect_peernum_ratio" => "0.00"
//        ],
//        "intimate_contact_info_30d" => [
//          "intimatenum" => 0,
//          "auth_intimatenum" => 0,
//          "auth_intimatenum_ratio" => "0.00",
//          "black_intimatenum" => 0,
//          "black_intimatenum_ratio" => "0.00",
//          "intimate_type" => "",
//          "auth_intimate_indirectnum" => 0,
//          "auth_intimate_indirectnum_ratio" => "0.00",
//          "black_intimate_indirectnum" => 0,
//          "black_intimate_indirectnum_ratio" => "0.00",
//          "black_intimate_indirect_peernum" => 0,
//          "black_intimate_indirect_peernum_ratio" => "0.00",
//          "auth_intimate_indirect_peernum" => 0,
//          "auth_intimate_indirect_peernum_ratio" => "0.00"
//        ],
//        "mobile_contact_90d" => [
//          "contactnum" => 0,
//          "auth_contactnum" => 0,
//          "auth_contact_ratio" => "0.00",
//          "black_contactnum" => 0,
//          "black_contactnum_ratio" => "0.00",
//          "contact_type" => "",
//          "auth_indirectnum" => 0,
//          "auth_indirectnum_ratio" => "0.00",
//          "black_indirectnum" => 0,
//          "black_indirectnum_ratio" => "0.00",
//          "black_indirect_peernum" => 0,
//          "black_indirect_peernum_ratio" => "0.00",
//          "auth_indirect_peernum" => 0,
//          "auth_indirect_peernum_ratio" => "0.00"
//        ],
//        "intimate_contact_info_90d" => [
//          "intimatenum" => 0,
//          "auth_intimatenum" => 0,
//          "auth_intimatenum_ratio" => "0.00",
//          "black_intimatenum" => 0,
//          "black_intimatenum_ratio" => "0.00",
//          "intimate_type" => "",
//          "auth_intimate_indirectnum" => 0,
//          "auth_intimate_indirectnum_ratio" => "0.00",
//          "black_intimate_indirectnum" => 0,
//          "black_intimate_indirectnum_ratio" => "0.00",
//          "black_intimate_indirect_peernum" => 0,
//          "black_intimate_indirect_peernum_ratio" => "0.00",
//          "auth_intimate_indirect_peernum" => 0,
//          "auth_intimate_indirect_peernum_ratio" => "0.00"
//        ],
//        "mobile_contact_180d" => [
//          "contactnum" => 0,
//          "auth_contactnum" => 0,
//          "auth_contact_ratio" => "0.00",
//          "black_contactnum" => 0,
//          "black_contactnum_ratio" => "0.00",
//          "contact_type" => "",
//          "auth_indirectnum" => 0,
//          "auth_indirectnum_ratio" => "0.00",
//          "black_indirectnum" => 0,
//          "black_indirectnum_ratio" => "0.00",
//          "black_indirect_peernum" => 0,
//          "black_indirect_peernum_ratio" => "0.00",
//          "auth_indirect_peernum" => 0,
//          "auth_indirect_peernum_ratio" => "0.00"
//        ],
//        "intimate_contact_info_180d" => [
//          "intimatenum" => 0,
//          "auth_intimatenum" => 0,
//          "auth_intimatenum_ratio" => "0.00",
//          "black_intimatenum" => 0,
//          "black_intimatenum_ratio" => "0.00",
//          "intimate_type" => "",
//          "auth_intimate_indirectnum" => 0,
//          "auth_intimate_indirectnum_ratio" => "0.00",
//          "black_intimate_indirectnum" => 0,
//          "black_intimate_indirectnum_ratio" => "0.00",
//          "black_intimate_indirect_peernum" => 0,
//          "black_intimate_indirect_peernum_ratio" => "0.00",
//          "auth_intimate_indirect_peernum" => 0,
//          "auth_intimate_indirect_peernum_ratio" => "0.00"
//        ]
//      ],
//      "auth_queried_detail" =>  [
//        "register_info" =>  [
//          "other_count" => 0,
//          "org_count" => 0,
//          "org_types" => []
//        ],
//        "queried_detail_org_count" => 0,
//        "queried_analyze" => [],
//        "queried_infos" => [],
//        "loan_org_cnt_all" => 0,
//        "loan_info" => [
//          "loan_org_cnt" => 0,
//          "loan_cnt" => 0,
//          "loan_org_cnt_15d" => 0,
//          "loan_org_cnt_30d" => 0,
//          "loan_org_cnt_90d" => 0,
//          "loan_org_cnt_180d" => 0,
//          "loan_cnt_15d" => 0,
//          "loan_cnt_30d" => 0,
//          "loan_cnt_90d" => 0,
//          "loan_cnt_180d" => 0
//        ]
//      ],
//      "risk_device" => [],
//      "credit_card" => [
//        "update_date" => "",
//        "bank_nums" => 0,
//        "card_amount" => 0,
//        "total_credit_limit" => "",
//        "max_credit_limit" => "",
//        "overdue_card" => 0,
//        "bill_nums" => 0,
//        "credit_overdue_item_12m" => [
//          "overdue_times" => 0,
//          "overdue_months" => 0
//        ],
//        "credit_overdue_item_6m" => [
//          "overdue_times" => 0,
//          "overdue_months" => 0
//        ],
//        "credit_overdue_item_3m" => [
//          "overdue_times" => 0,
//          "overdue_months" => 0
//        ],
//        "last_overdue_date" => "",
//        "max_overdue_money" => "",
//        "continue_overdue_times" => 0
//      ]
//    ],
//    "credit_qualification" => [
//      "trans_id" => "74ef74c0-ee29-11e8-a3bc-00163e0ed28c",
//      "person_info" => [
//        "idcard" => "13070219811107****",
//        "idcard_location" => "河北省/张家口市/桥东区",
//        "mobile" => "1381056****",
//        "carrier" => "中国移动",
//        "mobile_location" => "北京/北京",
//        "name" => "蔡*",
//        "age" => 37,
//        "gender" => "男",
//        "email" => "",
//        "education_info" => [
//          "level" => 0,
//          "is_graduation" => false
//        ]
//      ],
//      "qualification_info" => [
//        "zm_score_info" => [
//          "last_modify_time" => "",
//          "zm_score" => ""
//        ],
//        "huabei_info" => [
//          "last_modify_time" => "",
//          "huabai_limit" => ""
//        ],
//        "jiebei_info" => [
//          "last_modify_time" => "",
//          "credit_amt" => ""
//        ]
//      ]
//    ],
//    "post_load" => [
//      "trans_id" => "74fbd0d0-ee29-11e8-a3bc-00163e0ed28c",
//      "person_info" => [
//        "idcard" => "13070219811107****",
//        "idcard_location" => "河北省/张家口市/桥东区",
//        "mobile" => "1381056****",
//        "carrier" => "中国移动",
//        "mobile_location" => "北京/北京",
//        "name" => "蔡*",
//        "age" => 37,
//        "gender" => "男",
//        "email" => "",
//        "education_info" => [
//          "level" => 0,
//          "is_graduation" => false
//        ]
//      ],
//      "loan_behavior_analysis" => [
//        "defaultday_from_first_to_end" => "",
//        "feature_7d" => [
//          "jiedai4_sum_fail_cnt_d7" => "",
//          "jiedai_avg_defaultdays_d7" => "",
//          "jiedai4_count_fill_d3_cnt_d7" => "",
//          "jiedai_max_defaultdays_d7" => "",
//          "dd_jiedai_sum_fill_d5_cnt_d7" => "",
//          "dd_jiedai_count_fail_mamberadd_d7" => "",
//          "dd_jiedai_avg_fail_days1_d7" => "",
//          "jiedai_min_defaultdays_d7" => "",
//          "last_to_end_sure_due_all_pro_all_time_d7" => "",
//          "max_sure_due_days_non_cdq_all_time_d7" => "",
//          "sum_sure_due_days_all_pro_all_time_d7" => "",
//          "last_to_end_sure_due_non_cdq_all_time_d7" => ""
//        ],
//        "feature_15d" => [
//          "jiedai_avg_defaultdays_d15" => "",
//          "jiedai_min_defaultdays_d15" => "",
//          "jiedai4_sum_fail_cnt_d15" => "",
//          "dd_jiedai_avg_fail_days1_d15" => "",
//          "jiedai4_count_fill_d3_cnt_d15" => "",
//          "jiedai4_count_fill_d5_cnt_d15" => "",
//          "dd_jiedai_count_fail_mamberadd_d15" => "",
//          "jiedai_sum_fail_amt_d15" => "",
//          "dd_jiedai_max_fail_days1_d15" => "",
//          "sum_sure_due_days_all_pro_all_time_d15" => "",
//          "last_to_end_sure_due_all_pro_all_time_d15" => "",
//          "max_sure_due_days_non_cdq_all_time_d15" => "",
//          "last_to_end_sure_due_non_cdq_all_time_d15" => ""
//        ],
//        "feature_30d" => [
//          "jiedai_avg_defaultdays_m1" => "",
//          "dd_jiedai_max_fail_days1_m1" => "",
//          "jiedai4_sum_fail_cnt1" => "",
//          "dd_jiedai_max_fail_days_m1" => "",
//          "dd_jiedai_count_fail_mamberadd_m1" => "",
//          "jiedai4_count_fill_d3_cnt_m1" => "",
//          "dd_jiedai_min_fail_days1_m1" => "",
//          "jiedai_sum_fail_amt1" => "",
//          "cdq_dd_jiedai_max_fail_days1_m1" => "",
//          "jiedai4_count_fill_d5_cnt_m1" => "",
//          "jiedai4_avg_succ_amt1" => "",
//          "sum_sure_due_days_non_cdq_all_time_m1" => "",
//          "sum_sure_due_days_all_pro_all_time_m1" => "",
//          "avg_sure_due_days_non_cdq_all_time_m1" => "",
//          "pct_pay_amt_cdq_pro_all_time_m1" => "",
//          "max_pay_amt_all_pro_all_time_m1" => ""
//        ],
//        "feature_90d" => [
//          "jiedai_avg_defaultdays_m3" => "",
//          "dd_jiedai_max_fail_days1_m3" => "",
//          "dd_jiedai_avg_fail_days_m3" => "",
//          "dd_jiedai_count_fail_mamberadd_m3" => "",
//          "jiedai4_count_fill_d3_cnt_m3" => "",
//          "jiedai4_count_fill_d5_cnt_m3" => "",
//          "cdq_dd_jiedai_avg_fail_days1_m3" => "",
//          "jiedai4_avg_succ_amt3" => "",
//          "jiedai_sum_fail_amt3" => "",
//          "dd_jiedai_min_fail_days1_m3" => "",
//          "sum_sure_due_days_all_pro_all_time_m3" => "",
//          "sum_sure_due_days_non_cdq_all_time_m3" => "",
//          "avg_sure_due_days_all_pro_all_time_m3" => "",
//          "max_due_cnt_non_cdq_all_time_m3" => "",
//          "avg_sure_due_days_non_cdq_all_time_m3" => "",
//          "pct_pay_amt_cdq_pro_all_time_m3" => ""
//        ],
//        "feature_180d" => [
//          "jiedai_avg_defaultdays_m6" => "",
//          "dd_jiedai_avg_fail_days1_m6" => "",
//          "dd_jiedai_avg_fail_days_m6" => "",
//          "dd_jiedai_count_fail_mamberadd_m6" => "",
//          "jiedai4_count_fill_d3_cnt_m6" => "",
//          "cdq_dd_jiedai_avg_fail_days1_m6" => "",
//          "cdq_dd_jiedai_max_fail_days1_m6" => "",
//          "jiedai4_avg_succ_amt6" => "",
//          "jiedai4_count_fill_d5_cnt_m6" => "",
//          "sum_sure_due_days_non_cdq_all_time_m6" => "",
//          "max_sure_due_days_all_pro_all_time_m6" => "",
//          "avg_sure_due_days_all_pro_all_time_m6" => "",
//          "avg_sure_due_days_non_cdq_all_time_m6" => "",
//          "pct_pay_amt_cdq_pro_all_time_m6" => ""
//        ],
//        "feature_360d" => [
//          "dd_jiedai_max_fail_days_m12" => "",
//          "dd_jiedai_sum_fill_d5_cnt_m12" => "",
//          "last_to_end_sure_due_all_pro_all_time_m12" => "",
//          "sum_sure_due_days_non_cdq_all_time_m12" => "",
//          "last_to_end_sure_due_non_cdq_all_time_m12" => "",
//          "max_due_cnt_all_pro_all_time_m12" => "",
//          "max_due_cnt_non_cdq_all_time_m12" => "",
//          "max_pay_amt_all_pro_all_time_m12" => "",
//          "sum_pay_cnt_all_pro_all_time_m12" => ""
//        ]
//      ]
//    ],
//    "black_gray" => [
//      "trans_id" => "759acff0-ee29-11e8-9d68-00163e0d2aee",
//      "person_info" => [
//        "idcard" => "13070219811107****",
//        "idcard_location" => "河北省/张家口市/桥东区",
//        "mobile" => "1381056****",
//        "carrier" => "中国移动",
//        "mobile_location" => "北京/北京",
//        "name" => "蔡*",
//        "age" => 37,
//        "gender" => "男",
//        "email" => "",
//        "education_info" => [
//          "level" => 0,
//          "is_graduation" => false
//        ]
//      ],
//      "black_info_detail" => [
//        "mobile_name_in_blacklist" => false,
//        "mobile_name_blacklist_updated_time" => "",
//        "idcard_name_in_blacklist" => false,
//        "idcard_name_blacklist_updated_time" => "",
//        "black_types" => "",
//        "blacklist_record" => [
//          "overdue_count" => 0,
//          "overdue_amount" => "",
//          "overdue_status" => ""
//        ]
//      ],
//      "gray_info_detail" => [
//        "mobile_name_in_gray" => false,
//        "mobile_name_gray_updated_time" => "",
//        "idcard_name_in_gray" => false,
//        "idcard_name_gray_updated_time" => "",
//        "gray_types" => "",
//        "graylist_record" => [
//          "overdue_count" => 0,
//          "overdue_amount" => "",
//          "overdue_status" => ""
//        ]
//      ]
//    ],
//    "multi_info" => [
//      "trans_id" => "75b4e7a0-ee29-11e8-a3bc-00163e0ed28c",
//      "person_info" => [
//        "idcard" => "13070219811107****",
//        "idcard_location" => "河北省/张家口市/桥东区",
//        "mobile" => "1381056****",
//        "carrier" => "中国移动",
//        "mobile_location" => "北京/北京",
//        "name" => "蔡*",
//        "age" => 37,
//        "gender" => "男",
//        "email" => "",
//        "education_info" => [
//          "level" => 0,
//          "is_graduation" => false
//        ]
//      ],
//      "auth_queried_detail" => [
//        "register_info" => [
//          "other_count" => 0,
//          "org_count" => 0,
//          "org_types" => []
//        ],
//        "queried_detail_org_count" => 0,
//        "queried_analyze" => [],
//        "queried_infos" => [],
//        "loan_org_cnt_all" => 0,
//        "loan_info" => [
//          "loan_org_cnt" => 0,
//          "loan_cnt" => 0,
//          "loan_org_cnt_15d" => 0,
//          "loan_org_cnt_30d" => 0,
//          "loan_org_cnt_90d" => 0,
//          "loan_org_cnt_180d" => 0,
//          "loan_cnt_15d" => 0,
//          "loan_cnt_30d" => 0,
//          "loan_cnt_90d" => 0,
//          "loan_cnt_180d" => 0
//        ]
//      ]
//    ]
//  ],
//  "application" => [
//    "success" => true,
//    "code" => "0000",
//    "msg" => "操作成功",
//    "data" => [
//      "trans_id" => "74b10c30-ee29-11e8-a3bc-00163e0ed28c",
//      "person_info" => [
//        "idcard" => "13070219811107****",
//        "idcard_location" => "河北省/张家口市/桥东区",
//        "mobile" => "1381056****",
//        "carrier" => "中国移动",
//        "mobile_location" => "北京/北京",
//        "name" => "蔡*",
//        "age" => 37,
//        "gender" => "男",
//        "email" => "",
//        "education_info" => [
//          "level" => 0,
//          "is_graduation" => false
//        ]
//      ],
//      "black_info_detail" => [
//        "mobile_name_in_blacklist" => false,
//        "mobile_name_blacklist_updated_time" => "",
//        "idcard_name_in_blacklist" => false,
//        "idcard_name_blacklist_updated_time" => "",
//        "black_types" => "",
//        "blacklist_record" => [
//          "overdue_count" => 0,
//          "overdue_amount" => "",
//          "overdue_status" => ""
//        ]
//      ],
//      "gray_info_detail" => [
//        "mobile_name_in_gray" => false,
//        "mobile_name_gray_updated_time" => "",
//        "idcard_name_in_gray" => false,
//        "idcard_name_gray_updated_time" => "",
//        "gray_types" => "",
//        "graylist_record" => [
//          "overdue_count" => 0,
//          "overdue_amount" => "",
//          "overdue_status" => ""
//        ]
//      ],
//      "mobile_info" => [
//        "match_score" => 100,
//        "mobile_contact_30d" => [
//          "contactnum" => 0,
//          "auth_contactnum" => 0,
//          "auth_contact_ratio" => "0.00",
//          "black_contactnum" => 0,
//          "black_contactnum_ratio" => "0.00",
//          "contact_type" => "",
//          "auth_indirectnum" => 0,
//          "auth_indirectnum_ratio" => "0.00",
//          "black_indirectnum" => 0,
//          "black_indirectnum_ratio" => "0.00",
//          "black_indirect_peernum" => 0,
//          "black_indirect_peernum_ratio" => "0.00",
//          "auth_indirect_peernum" => 0,
//          "auth_indirect_peernum_ratio" => "0.00"
//        ],
//        "intimate_contact_info_30d" => [
//          "intimatenum" => 0,
//          "auth_intimatenum" => 0,
//          "auth_intimatenum_ratio" => "0.00",
//          "black_intimatenum" => 0,
//          "black_intimatenum_ratio" => "0.00",
//          "intimate_type" => "",
//          "auth_intimate_indirectnum" => 0,
//          "auth_intimate_indirectnum_ratio" => "0.00",
//          "black_intimate_indirectnum" => 0,
//          "black_intimate_indirectnum_ratio" => "0.00",
//          "black_intimate_indirect_peernum" => 0,
//          "black_intimate_indirect_peernum_ratio" => "0.00",
//          "auth_intimate_indirect_peernum" => 0,
//          "auth_intimate_indirect_peernum_ratio" => "0.00"
//        ],
//        "mobile_contact_90d" => [
//          "contactnum" => 0,
//          "auth_contactnum" => 0,
//          "auth_contact_ratio" => "0.00",
//          "black_contactnum" => 0,
//          "black_contactnum_ratio" => "0.00",
//          "contact_type" => "",
//          "auth_indirectnum" => 0,
//          "auth_indirectnum_ratio" => "0.00",
//          "black_indirectnum" => 0,
//          "black_indirectnum_ratio" => "0.00",
//          "black_indirect_peernum" => 0,
//          "black_indirect_peernum_ratio" => "0.00",
//          "auth_indirect_peernum" => 0,
//          "auth_indirect_peernum_ratio" => "0.00"
//        ],
//        "intimate_contact_info_90d" => [
//          "intimatenum" => 0,
//          "auth_intimatenum" => 0,
//          "auth_intimatenum_ratio" => "0.00",
//          "black_intimatenum" => 0,
//          "black_intimatenum_ratio" => "0.00",
//          "intimate_type" => "",
//          "auth_intimate_indirectnum" => 0,
//          "auth_intimate_indirectnum_ratio" => "0.00",
//          "black_intimate_indirectnum" => 0,
//          "black_intimate_indirectnum_ratio" => "0.00",
//          "black_intimate_indirect_peernum" => 0,
//          "black_intimate_indirect_peernum_ratio" => "0.00",
//          "auth_intimate_indirect_peernum" => 0,
//          "auth_intimate_indirect_peernum_ratio" => "0.00"
//        ],
//        "mobile_contact_180d" => [
//          "contactnum" => 0,
//          "auth_contactnum" => 0,
//          "auth_contact_ratio" => "0.00",
//          "black_contactnum" => 0,
//          "black_contactnum_ratio" => "0.00",
//          "contact_type" => "",
//          "auth_indirectnum" => 0,
//          "auth_indirectnum_ratio" => "0.00",
//          "black_indirectnum" => 0,
//          "black_indirectnum_ratio" => "0.00",
//          "black_indirect_peernum" => 0,
//          "black_indirect_peernum_ratio" => "0.00",
//          "auth_indirect_peernum" => 0,
//          "auth_indirect_peernum_ratio" => "0.00"
//        ],
//        "intimate_contact_info_180d" => [
//          "intimatenum" => 0,
//          "auth_intimatenum" => 0,
//          "auth_intimatenum_ratio" => "0.00",
//          "black_intimatenum" => 0,
//          "black_intimatenum_ratio" => "0.00",
//          "intimate_type" => "",
//          "auth_intimate_indirectnum" => 0,
//          "auth_intimate_indirectnum_ratio" => "0.00",
//          "black_intimate_indirectnum" => 0,
//          "black_intimate_indirectnum_ratio" => "0.00",
//          "black_intimate_indirect_peernum" => 0,
//          "black_intimate_indirect_peernum_ratio" => "0.00",
//          "auth_intimate_indirect_peernum" => 0,
//          "auth_intimate_indirect_peernum_ratio" => "0.00"
//        ]
//      ],
//      "auth_queried_detail" => [
//        "register_info" => [
//          "other_count" => 0,
//          "org_count" => 0,
//          "org_types" => []
//        ],
//        "queried_detail_org_count" => 0,
//        "queried_analyze" => [],
//        "queried_infos" => [],
//        "loan_org_cnt_all" => 0,
//        "loan_info" => [
//          "loan_org_cnt" => 0,
//          "loan_cnt" => 0,
//          "loan_org_cnt_15d" => 0,
//          "loan_org_cnt_30d" => 0,
//          "loan_org_cnt_90d" => 0,
//          "loan_org_cnt_180d" => 0,
//          "loan_cnt_15d" => 0,
//          "loan_cnt_30d" => 0,
//          "loan_cnt_90d" => 0,
//          "loan_cnt_180d" => 0
//        ]
//      ],
//      "risk_device" => [],
//      "credit_card" => [
//        "update_date" => "",
//        "bank_nums" => 0,
//        "card_amount" => 0,
//        "total_credit_limit" => "",
//        "max_credit_limit" => "",
//        "overdue_card" => 0,
//        "bill_nums" => 0,
//        "credit_overdue_item_12m" => [
//          "overdue_times" => 0,
//          "overdue_months" => 0
//        ],
//        "credit_overdue_item_6m" => [
//          "overdue_times" => 0,
//          "overdue_months" => 0
//        ],
//        "credit_overdue_item_3m" => [
//          "overdue_times" => 0,
//          "overdue_months" => 0
//        ],
//        "last_overdue_date" => "",
//        "max_overdue_money" => "",
//        "continue_overdue_times" => 0
//      ]
//    ],
//    "fee" => "Y"
//  ],
//  "credit_qualification" => [
//    "success" => true,
//    "code" => "0000",
//    "msg" => "操作成功",
//    "data" => [
//      "trans_id" => "74ef74c0-ee29-11e8-a3bc-00163e0ed28c",
//      "person_info" => [
//        "idcard" => "13070219811107****",
//        "idcard_location" => "河北省/张家口市/桥东区",
//        "mobile" => "1381056****",
//        "carrier" => "中国移动",
//        "mobile_location" => "北京/北京",
//        "name" => "蔡*",
//        "age" => 37,
//        "gender" => "男",
//        "email" => "",
//        "education_info" => [
//          "level" => 0,
//          "is_graduation" => false
//        ]
//      ],
//      "qualification_info" => [
//        "zm_score_info" => [
//          "last_modify_time" => "",
//          "zm_score" => ""
//        ],
//        "huabei_info" => [
//          "last_modify_time" => "",
//          "huabai_limit" => ""
//        ],
//        "jiebei_info" => [
//          "last_modify_time" => "",
//          "credit_amt" => ""
//        ]
//      ]
//    ],
//    "fee" => "N"
//  ],
//  "post_load" => [
//    "success" => true,
//    "code" => "0000",
//    "msg" => "操作成功",
//    "data" => [
//      "trans_id" => "74fbd0d0-ee29-11e8-a3bc-00163e0ed28c",
//      "person_info" => [
//        "idcard" => "13070219811107****",
//        "idcard_location" => "河北省/张家口市/桥东区",
//        "mobile" => "1381056****",
//        "carrier" => "中国移动",
//        "mobile_location" => "北京/北京",
//        "name" => "蔡*",
//        "age" => 37,
//        "gender" => "男",
//        "email" => "",
//        "education_info" => [
//          "level" => 0,
//          "is_graduation" => false
//        ]
//      ],
//      "loan_behavior_analysis" => [
//        "defaultday_from_first_to_end" => "",
//        "feature_7d" => [
//          "jiedai4_sum_fail_cnt_d7" => "",
//          "jiedai_avg_defaultdays_d7" => "",
//          "jiedai4_count_fill_d3_cnt_d7" => "",
//          "jiedai_max_defaultdays_d7" => "",
//          "dd_jiedai_sum_fill_d5_cnt_d7" => "",
//          "dd_jiedai_count_fail_mamberadd_d7" => "",
//          "dd_jiedai_avg_fail_days1_d7" => "",
//          "jiedai_min_defaultdays_d7" => "",
//          "last_to_end_sure_due_all_pro_all_time_d7" => "",
//          "max_sure_due_days_non_cdq_all_time_d7" => "",
//          "sum_sure_due_days_all_pro_all_time_d7" => "",
//          "last_to_end_sure_due_non_cdq_all_time_d7" => ""
//        ],
//        "feature_15d" => [
//          "jiedai_avg_defaultdays_d15" => "",
//          "jiedai_min_defaultdays_d15" => "",
//          "jiedai4_sum_fail_cnt_d15" => "",
//          "dd_jiedai_avg_fail_days1_d15" => "",
//          "jiedai4_count_fill_d3_cnt_d15" => "",
//          "jiedai4_count_fill_d5_cnt_d15" => "",
//          "dd_jiedai_count_fail_mamberadd_d15" => "",
//          "jiedai_sum_fail_amt_d15" => "",
//          "dd_jiedai_max_fail_days1_d15" => "",
//          "sum_sure_due_days_all_pro_all_time_d15" => "",
//          "last_to_end_sure_due_all_pro_all_time_d15" => "",
//          "max_sure_due_days_non_cdq_all_time_d15" => "",
//          "last_to_end_sure_due_non_cdq_all_time_d15" => ""
//        ],
//        "feature_30d" => [
//          "jiedai_avg_defaultdays_m1" => "",
//          "dd_jiedai_max_fail_days1_m1" => "",
//          "jiedai4_sum_fail_cnt1" => "",
//          "dd_jiedai_max_fail_days_m1" => "",
//          "dd_jiedai_count_fail_mamberadd_m1" => "",
//          "jiedai4_count_fill_d3_cnt_m1" => "",
//          "dd_jiedai_min_fail_days1_m1" => "",
//          "jiedai_sum_fail_amt1" => "",
//          "cdq_dd_jiedai_max_fail_days1_m1" => "",
//          "jiedai4_count_fill_d5_cnt_m1" => "",
//          "jiedai4_avg_succ_amt1" => "",
//          "sum_sure_due_days_non_cdq_all_time_m1" => "",
//          "sum_sure_due_days_all_pro_all_time_m1" => "",
//          "avg_sure_due_days_non_cdq_all_time_m1" => "",
//          "pct_pay_amt_cdq_pro_all_time_m1" => "",
//          "max_pay_amt_all_pro_all_time_m1" => ""
//        ],
//        "feature_90d" => [
//          "jiedai_avg_defaultdays_m3" => "",
//          "dd_jiedai_max_fail_days1_m3" => "",
//          "dd_jiedai_avg_fail_days_m3" => "",
//          "dd_jiedai_count_fail_mamberadd_m3" => "",
//          "jiedai4_count_fill_d3_cnt_m3" => "",
//          "jiedai4_count_fill_d5_cnt_m3" => "",
//          "cdq_dd_jiedai_avg_fail_days1_m3" => "",
//          "jiedai4_avg_succ_amt3" => "",
//          "jiedai_sum_fail_amt3" => "",
//          "dd_jiedai_min_fail_days1_m3" => "",
//          "sum_sure_due_days_all_pro_all_time_m3" => "",
//          "sum_sure_due_days_non_cdq_all_time_m3" => "",
//          "avg_sure_due_days_all_pro_all_time_m3" => "",
//          "max_due_cnt_non_cdq_all_time_m3" => "",
//          "avg_sure_due_days_non_cdq_all_time_m3" => "",
//          "pct_pay_amt_cdq_pro_all_time_m3" => ""
//        ],
//        "feature_180d" => [
//          "jiedai_avg_defaultdays_m6" => "",
//          "dd_jiedai_avg_fail_days1_m6" => "",
//          "dd_jiedai_avg_fail_days_m6" => "",
//          "dd_jiedai_count_fail_mamberadd_m6" => "",
//          "jiedai4_count_fill_d3_cnt_m6" => "",
//          "cdq_dd_jiedai_avg_fail_days1_m6" => "",
//          "cdq_dd_jiedai_max_fail_days1_m6" => "",
//          "jiedai4_avg_succ_amt6" => "",
//          "jiedai4_count_fill_d5_cnt_m6" => "",
//          "sum_sure_due_days_non_cdq_all_time_m6" => "",
//          "max_sure_due_days_all_pro_all_time_m6" => "",
//          "avg_sure_due_days_all_pro_all_time_m6" => "",
//          "avg_sure_due_days_non_cdq_all_time_m6" => "",
//          "pct_pay_amt_cdq_pro_all_time_m6" => ""
//        ],
//        "feature_360d" => [
//          "dd_jiedai_max_fail_days_m12" => "",
//          "dd_jiedai_sum_fill_d5_cnt_m12" => "",
//          "last_to_end_sure_due_all_pro_all_time_m12" => "",
//          "sum_sure_due_days_non_cdq_all_time_m12" => "",
//          "last_to_end_sure_due_non_cdq_all_time_m12" => "",
//          "max_due_cnt_all_pro_all_time_m12" => "",
//          "max_due_cnt_non_cdq_all_time_m12" => "",
//          "max_pay_amt_all_pro_all_time_m12" => "",
//          "sum_pay_cnt_all_pro_all_time_m12" => ""
//        ]
//      ]
//    ],
//    "fee" => "N"
//  ],
//  "black_gray" => [
//    "success" => true,
//    "code" => "0000",
//    "msg" => "操作成功",
//    "data" => [
//      "trans_id" => "759acff0-ee29-11e8-9d68-00163e0d2aee",
//      "person_info" => [
//        "idcard" => "13070219811107****",
//        "idcard_location" => "河北省/张家口市/桥东区",
//        "mobile" => "1381056****",
//        "carrier" => "中国移动",
//        "mobile_location" => "北京/北京",
//        "name" => "蔡*",
//        "age" => 37,
//        "gender" => "男",
//        "email" => "",
//        "education_info" => [
//          "level" => 0,
//          "is_graduation" => false
//        ]
//      ],
//      "black_info_detail" => [
//        "mobile_name_in_blacklist" => false,
//        "mobile_name_blacklist_updated_time" => "",
//        "idcard_name_in_blacklist" => false,
//        "idcard_name_blacklist_updated_time" => "",
//        "black_types" => "",
//        "blacklist_record" => [
//          "overdue_count" => 0,
//          "overdue_amount" => "",
//          "overdue_status" => ""
//        ]
//      ],
//      "gray_info_detail" => [
//        "mobile_name_in_gray" => false,
//        "mobile_name_gray_updated_time" => "",
//        "idcard_name_in_gray" => false,
//        "idcard_name_gray_updated_time" => "",
//        "gray_types" => "",
//        "graylist_record" => [
//          "overdue_count" => 0,
//          "overdue_amount" => "",
//          "overdue_status" => ""
//        ]
//      ]
//    ],
//    "fee" => "Y"
//  ],
//  "multi_info" => [
//    "success" => true,
//    "code" => "0000",
//    "msg" => "操作成功",
//    "data" => [
//      "trans_id" => "75b4e7a0-ee29-11e8-a3bc-00163e0ed28c",
//      "person_info" => [
//        "idcard" => "13070219811107****",
//        "idcard_location" => "河北省/张家口市/桥东区",
//        "mobile" => "1381056****",
//        "carrier" => "中国移动",
//        "mobile_location" => "北京/北京",
//        "name" => "蔡*",
//        "age" => 37,
//        "gender" => "男",
//        "email" => "",
//        "education_info" => [
//          "level" => 0,
//          "is_graduation" => false
//        ]
//      ],
//      "auth_queried_detail" => [
//        "register_info" => [
//          "other_count" => 0,
//          "org_count" => 0,
//          "org_types" => []
//        ],
//        "queried_detail_org_count" => 0,
//        "queried_analyze" => [],
//        "queried_infos" => [],
//        "loan_org_cnt_all" => 0,
//        "loan_info" => [
//          "loan_org_cnt" => 0,
//          "loan_cnt" => 0,
//          "loan_org_cnt_15d" => 0,
//          "loan_org_cnt_30d" => 0,
//          "loan_org_cnt_90d" => 0,
//          "loan_org_cnt_180d" => 0,
//          "loan_cnt_15d" => 0,
//          "loan_cnt_30d" => 0,
//          "loan_cnt_90d" => 0,
//          "loan_cnt_180d" => 0
//        ]
//      ]
//    ],
//    "fee" => "Y"
//  ]
//];

        OrderStrategy::reportBak($res);
    }
}