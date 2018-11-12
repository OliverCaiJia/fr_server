<?php

namespace App\Models\Factory\Api;

use App\Constants\UserVipConstant;
use App\Helpers\Utils;
use App\Models\Orm\AccountPayment;
use App\Models\Orm\Platform;
use App\Models\Orm\UserOrder;
use App\Models\Orm\UserOrderType;
use Illuminate\Support\Facades\DB;

class UserOrderFactory extends ApiFactory
{
    /**
     * 创建订单
     *
     * @param $data
     * @return \Illuminate\Database\Eloquent\Model
     */
    public static function createOrder($params)
    {
        $userOrderObj = new UserOrder();
        $userOrderObj->user_id = $params['user_id'];
        $userOrderObj->bank_id = $params['bank_id'];
        $userOrderObj->order_no = $params['order_no'];
        $userOrderObj->payment_order_no = $params['payment_order_no'];//类型+时间+有意义的串
        $userOrderObj->order_expired = $params['order_expired'];
        $userOrderObj->order_type = $params['order_type'];
        $userOrderObj->payment_type = $params['payment_type'];
        $userOrderObj->pay_type = $params['pay_type'];
        $userOrderObj->terminaltype = $params['terminaltype'];
        $userOrderObj->terminalid = $params['terminalid'];
        $userOrderObj->card_num = $params['card_num'];
        $userOrderObj->lastno = $params['lastno'];
        $userOrderObj->cardtype = $params['cardtype'];
        $userOrderObj->amount = $params['amount'];
        $userOrderObj->status = $params['status'];
        $userOrderObj->request_text = $params['request_text'];
        $userOrderObj->response_text = $params['response_text'];
        $userOrderObj->user_agent = $params['user_agent'];
        $userOrderObj->create_ip = Utils::ipAddress();
        $userOrderObj->update_ip = Utils::ipAddress();
        $userOrderObj->create_at = date('Y-m-d H:i:s', time());
        return $userOrderObj->save();
    }

    /**
     * 根据用户id和订单号更新订单状态
     * @param $userId
     * @param $orderNo
     * @param $status
     * @return mixed
     */
    public static function updateOrderByUserId($userId, $orderNo, $status)
    {
        return UserOrder::where(['user_id' => $userId, 'order_no' => $orderNo])->update(['status' => $status]);
    }

    /**
     * 获取订单类型ID
     *
     * @param string $nid
     * @return int
     */
    public static function getOrderType($nid = UserVipConstant::ORDER_TYPE)
    {
        $id = UserOrderType::where(['type_nid' => $nid])->value('id');

        return $id ? $id : 1;
    }

    /**
     * 根据订单编号和用户id获取订单
     * @param $orderNo
     * @param $userId
     * @return \Illuminate\Support\Collection
     */
    public static function getOrderDetailByOrderNoAndUserId($orderNo, $userId)
    {
        $userOrder = DB::table(UserOrder::TABLE_NAME)
            ->where([UserOrder::TABLE_NAME . '.order_no' => $orderNo])
            ->where([UserOrder::TABLE_NAME . '.user_id' => $userId])
            ->leftJoin(Platform::TABLE_NAME, UserOrder::TABLE_NAME . '.platform_nid', '=', Platform::TABLE_NAME . '.platform_nid')
            ->get();

        return $userOrder;
    }

    /**
     * 根据用户id获取订单列表
     * @param $userId
     * @return mixed
     */
    public static function getOrderByUserId($userId)
    {
        return UserOrder::select()->where('user_id', '=', $userId)->get();
    }

    /**
     * @param $userId
     * @param $orderNo
     * @return mixed
     */
    public static function getOrderStatusByUserIdOrderNo($userId, $orderNo)
    {
        return UserOrder::select()
            ->where('user_id', '=', $userId)
            ->where('order_no', '=', $orderNo)
            ->get();
    }
}
