<?php

namespace App\Models\Chain\Report\Scopion;

use App\Constants\OrderConstant;
use App\Models\Chain\AbstractHandler;
use App\Models\Factory\Api\UserOrderFactory;

class CreateMultiinfoAction extends AbstractHandler
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
        if ($this->createMultiinfo($this->params)) {
            $this->setSuccessor(new CreatePersonalAction($this->params));
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

    private function createMultiinfo($params)
    {
//        CREATE TABLE `sgd_user_multiinfo` (
//    `id` int(11) unsigned NOT NULL AUTO_INCREMENT COMMENT 'id',
//  `user_id` int(11) unsigned NOT NULL COMMENT '用户id',
//  `user_report_id` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '关联的user_reports表的id',
//  `register_org_count` int(8) NOT NULL DEFAULT '0' COMMENT '注册机构数量',
//  `loan_cnt` int(8) NOT NULL DEFAULT '0' COMMENT '借贷次数',
//  `loan_org_cnt` int(8) NOT NULL DEFAULT '0' COMMENT '借贷机构数',
//  `transid` varchar(128) NOT NULL DEFAULT '' COMMENT '传输id',
//  `data` json NOT NULL,
//  `fee` varchar(255) NOT NULL DEFAULT '',
//  `create_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP COMMENT '创建时间',
//  `update_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP COMMENT '更新时间',
//  PRIMARY KEY (`id`),
//  KEY `FK_USER_MULTIINFO_USER_ID` (`user_id`),
//  CONSTRAINT `FK_USER_MULTIINFO_USER_ID` FOREIGN KEY (`user_id`) REFERENCES `sgd_user_auth` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
//) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COMMENT='用户多头数据表'

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

        $data['user_id'] = $params['user_id'];//
        $data['user_report_id'] = $params['user_report_id'];//
        $data['register_org_count'] = $params['multi_info']['data']['auth_queried_detail']['register_info']['org_count'];//

        $data['loan_cnt'] = $params['multi_info']['data']['auth_queried_detail']['loan_info']['loan_cnt'];//
        $data['loan_org_cnt'] = $params['multi_info']['data']['auth_queried_detail']['loan_info']['loan_org_cnt'];//
        $data['transid'] = $params['multi_info']['data']['trans_id'];//
        $data['data'] = json_encode($params['multi_info']['data']);//'{"people":[{"firstName":"Brett","lastName":"McLaughlin","email":"aaaa"},{"firstName":"Jason","lastName":"Hunter","email":"bbbb"},{"firstName":"Elliotte","lastName":"Harold","email":"cccc"}]}'
        $data['fee'] = $params['multi_info']['fee'];//'Y'
        $data['create_at'] = date('Y-m-d H:i:s', time());
        $data['update_at'] = date('Y-m-d H:i:s', time());

        $userMultiinfo = UserOrderFactory::createMultiinfo($data);

//        $userId = $params['user_id'];
//        $orderType = $params['order_type'];
//        $userOrder = UserOrderFactory::getUserOrderByUserIdAndOrderType($userId, $orderType);
//
        if (!$userMultiinfo) {
            $this->error['error'] = "您好，报告记录关系异常！";
            return false;
        }
        return true;
    }
}
