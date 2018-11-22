<?php

namespace App\Models\Chain\Report\Scopion;

use App\Constants\OrderConstant;
use App\Models\Chain\AbstractHandler;
use App\Models\Factory\Api\UserOrderFactory;

class CreateBlackListAction extends AbstractHandler
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
        if ($this->createBlackList($this->params)) {
            $this->setSuccessor(new CreateMultiinfoAction($this->params));
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

    private function createBlackList($params)
    {
//        CREATE TABLE `sgd_user_blacklist` (
//    `id` int(11) unsigned NOT NULL AUTO_INCREMENT COMMENT 'id',
//  `user_id` int(11) unsigned NOT NULL COMMENT '用户id',
//  `user_report_id` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '关联的user_reports表的id',
//  `transid` varchar(128) NOT NULL DEFAULT '' COMMENT '传输id',
//  `mobile_name_in_blacklist` tinyint(1) NOT NULL DEFAULT '0' COMMENT '姓名手机是否在黑名单',
//  `idcard_name_in_blacklist` tinyint(1) NOT NULL DEFAULT '0' COMMENT '身份证和姓名是否在黑名单',
//  `black_info_detail` json NOT NULL COMMENT '黑名单信息',
//  `gray_info_detail` json NOT NULL COMMENT '灰名单信息',
//  `data` json NOT NULL COMMENT '数据',
//  `fee` varchar(32) NOT NULL DEFAULT '' COMMENT '是否收费',
//  `create_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP COMMENT '创建时间',
//  `update_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP COMMENT '更新时间',
//  PRIMARY KEY (`id`),
//  KEY `FK_USER_BLACKLIST_USER_ID` (`user_id`),
//  CONSTRAINT `FK_USER_BLACKLIST_USER_ID` FOREIGN KEY (`user_id`) REFERENCES `sgd_user_auth` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
//) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4

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

        $data['user_id'] = $params['user_id'];//
        $data['user_report_id'] = $params['user_report_id'];//
        $data['transid'] = $params['black_gray']['data']['trans_id'];//$params['transid']
        $data['mobile_name_in_blacklist'] = (int)$params['black_gray']['data']['black_info_detail']['mobile_name_in_blacklist'];//
        $data['idcard_name_in_blacklist'] = (int)$params['black_gray']['data']['black_info_detail']['idcard_name_in_blacklist'];//
        $data['black_info_detail'] = json_encode($params['black_gray']['data']['black_info_detail']);//'{"people":[{"firstName":"Brett","lastName":"McLaughlin","email":"aaaa"},{"firstName":"Jason","lastName":"Hunter","email":"bbbb"},{"firstName":"Elliotte","lastName":"Harold","email":"cccc"}]}'
        $data['gray_info_detail'] = json_encode($params['black_gray']['data']['gray_info_detail']);//'{"people":[{"firstName":"Brett","lastName":"McLaughlin","email":"aaaa"},{"firstName":"Jason","lastName":"Hunter","email":"bbbb"},{"firstName":"Elliotte","lastName":"Harold","email":"cccc"}]}'
        $data['data'] = json_encode($params['black_gray']['data']);//'{"people":[{"firstName":"Brett","lastName":"McLaughlin","email":"aaaa"},{"firstName":"Jason","lastName":"Hunter","email":"bbbb"},{"firstName":"Elliotte","lastName":"Harold","email":"cccc"}]}'
        $data['fee'] = $params['black_gray']['fee'];//
        $data['create_at'] = date('Y-m-d H:i:s', time());
        $data['update_at'] = date('Y-m-d H:i:s', time());
//dd($data);
//        array:11 [▼
//  "user_id" => 6
//  "user_report_id" => 116
//  "transid" => "601258f0-ee11-11e8-a3bc-00163e0ed28c"
//  "mobile_name_in_blacklist" => false
//  "idcard_name_in_blacklist" => false
//  "black_info_detail" => array:6 [▶]
//  "gray_info_detail" => array:6 [▶]
//  "data" => array:4 [▶]
//  "fee" => "Y"
//  "create_at" => "2018-11-22 14:36:32"
//  "update_at" => "2018-11-22 14:36:32"
//]



        $userReportLog = UserOrderFactory::createBlackList($data);

//        $userId = $params['user_id'];
//        $orderType = $params['order_type'];
//        $userOrder = UserOrderFactory::getUserOrderByUserIdAndOrderType($userId, $orderType);
//
        if (!$userReportLog) {
            $this->error['error'] = "您好，报告记录关系异常！";
            return false;
        }
        return true;
    }
}
