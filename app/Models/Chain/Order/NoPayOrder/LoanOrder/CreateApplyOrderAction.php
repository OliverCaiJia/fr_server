<?php

namespace App\Models\Chain\Order\NoPayOrder\LoanOrder;

use App\Constants\UserOrderConstant;
use App\Helpers\Logger\SLogger;
use App\Helpers\Utils;
use App\Models\Chain\AbstractHandler;
use App\Models\Factory\Api\UserOrderFactory;
use App\Models\Orm\UserOrderType;
use App\Strategies\UserOrderStrategy;

class CreateApplyOrderAction extends AbstractHandler
{
    private $params = [];
    protected $error = ['error' => '您好，订单还未付费！', 'code' => 8010];

    public function __construct($params)
    {
        $this->params = $params;
    }


    public function handleRequest()
    {
        if ($this->createApplyOrder($this->params)) {
            $this->setSuccessor(new CreatePushTaskAction($this->params));
            return $this->getSuccessor()->handleRequest();
        } else {
            return $this->error;
        }
    }

    private function createApplyOrder($params)
    {
        SLogger::getStream()->error(__CLASS__);
        $applyOrder = [];
        $applyOrder['user_id'] = $params['user_id'];
        $orderTypeNid = 'order_apply';
        $extra = UserOrderStrategy::getExtra($orderTypeNid);
        $data['order_no'] = UserOrderStrategy::createOrderNo($extra);
        $orderType = UserOrderFactory::getOrderTypeByTypeNid($orderTypeNid);
        $data['order_type'] = $orderType['id'];
        $data['p_order_id'] = 0;//没有父级订单
        $data['amount'] = 0;//免费订单金额为零
        $borrowLog = UserOrderFactory::getBorrowLogByUserId($params['user_id']);
        $data['term'] = $borrowLog['term'];
        $data['money'] = $borrowLog['money'];
        $data['count'] = 1;//订单数量为一
        $data['status'] = 0;//订单为未支付
        $data['create_ip'] = Utils::ipAddress();
        $data['create_at'] = date('Y-m-d H:i:s', time());
        $data['update_ip'] = Utils::ipAddress();
        $data['update_at'] = date('Y-m-d H:i:s', time());

        $result = UserOrderFactory::createOrder($data);

//        CREATE TABLE `sgd_user_order` (
//    `id` int(11) unsigned NOT NULL AUTO_INCREMENT COMMENT 'id',
//  `user_id` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '用户ID',
//  `order_no` varchar(32) NOT NULL DEFAULT '' COMMENT '订单号',
//  `order_type` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '订单类型',
//  `p_order_id` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '是否是子订单',
//  `order_expired` datetime NOT NULL DEFAULT '1970-01-01 00:00:00' COMMENT '订单有效期',
//  `amount` decimal(15,2) NOT NULL DEFAULT '0.00' COMMENT '订单金额 ，以分为单位的整型',
//  `money` decimal(15,2) NOT NULL DEFAULT '0.00' COMMENT '订单金额 ，以分为单位的整型',
//  `term` tinyint(11) NOT NULL COMMENT '订单期限',
//  `count` int(11) unsigned NOT NULL DEFAULT '1' COMMENT '订单数量',
//  `status` tinyint(4) unsigned NOT NULL DEFAULT '0' COMMENT '订单状态 0:订单处理中 1:订单处理完成 2:订单过期 3:订单撤销 4订单失败 ',
//  `create_ip` varchar(32) NOT NULL DEFAULT '' COMMENT '用户支付时使用的网络终端IP',
//  `create_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP COMMENT '创建时间',
//  `update_ip` varchar(32) NOT NULL DEFAULT '' COMMENT '更新IP',
//  `update_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP COMMENT '更新时间',
//  PRIMARY KEY (`id`) USING BTREE,
//  KEY `FK_USER_ORDER_ORDER_TYPE` (`order_type`),
//  KEY `FK_USER_ORDER_UID_ORDERID` (`user_id`,`order_no`) USING BTREE COMMENT '用户ID和订单号的联合索引',
//  KEY `INDEX_USER_ID` (`user_id`),
//  KEY `INDEX_STATUS` (`status`),
//  CONSTRAINT `FK_USER_ORDER_ORDER_TYPE` FOREIGN KEY (`order_type`) REFERENCES `sgd_user_order_type` (`id`) ON UPDATE CASCADE,
//  CONSTRAINT `FK_USER_ORDER_USER_ID` FOREIGN KEY (`user_id`) REFERENCES `sgd_user_auth` (`id`) ON UPDATE CASCADE
//) ENGINE=InnoDB AUTO_INCREMENT=287 DEFAULT CHARSET=utf8 COMMENT='用户订单表'

//        $userOrderObj->order_no = $params['order_no'];
//        $userOrderObj->order_type = $params['order_type'];
//        $userOrderObj->p_order_id = $params['p_order_id'];
//        $userOrderObj->order_expired = $params['order_expired'];//读配置
//        $userOrderObj->amount = $params['amount'];
//        $userOrderObj->term = $params['term'];
//        $userOrderObj->count = $params['count'];
//        $userOrderObj->status = $params['status'];
//        $userOrderObj->create_ip = $params['create_ip'];
//        $userOrderObj->create_at = $params['create_at'];
//        $userOrderObj->update_ip = $params['update_ip'];
//        $userOrderObj->update_at = $params['update_at'];


        if (empty($result)) {
            $this->error['error'] = "用户您好，贷款订单没有生成.";
            return false;
        }
        return true;
    }
}
