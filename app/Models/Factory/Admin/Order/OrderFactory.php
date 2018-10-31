<?php

namespace App\Models\Factory\Admin\Order;

use App\Models\AbsBaseModel;
use App\Models\Orm\SaasOrderSaas;
use App\Models\Orm\UserOrder;
use App\Models\Orm\UserOrderRefuseReason;

class OrderFactory extends AbsBaseModel
{
    /**
     * 获取订单详情
     *
     * @param $id
     *
     * @return \Illuminate\Database\Eloquent\Collection|\Illuminate\Database\Eloquent\Model
     */
    public static function getDetail($id)
    {
        return UserOrder::with('userReport')->findOrFail($id);
    }

    /**
     * 通过订单ID获取订单信息
     *
     * @param $id
     *
     * @return array
     */
    public static function getOrderInfoById($id)
    {
        return UserOrder::lockForUpdate()->whereKey($id)->first();
    }

    /**
     * 根据订单ID更新当前处理人
     *
     * @param $orderId
     * @param $personId
     *
     * @return bool
     */
    public static function updateSaasAuthId($orderId, $personId)
    {
        return UserOrder::where('id', $orderId)->update(['person_id' => $personId]);
    }

    /**
     * 根据 id 条件更新 person_id
     *
     * @param integer $id
     * @param integer $personId
     *
     * @return bool
     */
    public static function updateSaasAuthPersonIdById($id, $personId)
    {
        return SaasOrderSaas::where('id', $id)->update(['person_id' => $personId]);
    }

    /**
     * 根据订单ID更新当前处理人和分单时间
     * @param $orderId
     * @param $personId
     * @param $assignedAt
     * @return bool
     */
    public static function updatePersonIdAssignedAt($orderId, $personId, $assignedAt)
    {
        return UserOrder::where('id', $orderId)->update(['person_id' => $personId, 'assigned_at' => $assignedAt]);
    }

    /**
     * 根据订单ID，更新订单状态
     *
     * @param $id
     * @param $status
     *
     * @return bool
     */
    public static function updateStatus($id, $status)
    {
        return UserOrder::where('id', $id)->update(['status' => $status]);
    }

    /**
     * 插入订单审批拒绝原因
     *
     * @param $orderId
     * @param $reason
     *
     * @return \Illuminate\Database\Eloquent\Model
     */
    public static function insertRefuseReason($orderId, $reason)
    {
        return UserOrderRefuseReason::updateOrCreate(['saas_order_id' => $orderId], [
            'saas_order_id' => $orderId,
            'reason' => $reason
        ]);
    }

    /**
     * 通过订单ID获得拒绝理由
     *
     * @param $orderId
     *
     * @return mixed|string
     */
    public static function getReasonByOrderId($orderId)
    {
        $reason = UserOrderRefuseReason::where(['saas_order_id' => $orderId])->first();
        return $reason ? $reason->reason : '';
    }

    /**
     * 通过报告 id 获取订单来源
     *
     * @param $reportId
     *
     * @return \Illuminate\Database\Eloquent\Model|null|object|static
     */
    public static function getSourceByReportId($reportId)
    {
        return UserOrder::where('user_report_id', $reportId)->select('source')->first();
    }

    /**
     * 通过 person_id 获取一条订单
     *
     * @param $personId
     *
     * @return \Illuminate\Database\Eloquent\Model|null|object|static
     */
    public static function getByPersonId($personId)
    {
        return UserOrder::where('person_id', $personId)->first();
    }

    /**
     * 根据不同筛选条件查询多条数据
     * @param array $params
     * @return array
     */
    public static function getAll(array $params = [])
    {
        $query = new UserOrder();

        if (!empty($params['select'])) {
            $query = $query->select($params['select']);
        }

        if (!empty($params['where'])) {
            $query = $query->where($params['where']);
        }

        if (!empty($params['where_in'])) {
            foreach ($params['where_in'] as $in_k => $in_v) {
                $query = $query->whereIn($in_k, $in_v);
            }
        }

        if (!empty($params['where_not_in'])) {
            foreach ($params['where_not_in'] as $not_in_k => $not_in_v) {
                $query = $query->whereNotIn($not_in_k, $not_in_v);
            }
        }

        if (!empty($params['or'])) {
            $or = $params['or'];
            $query = $query->where(function ($query) use ($or) {
                foreach ($or as $item) {
                    $query = $query->orWhere($item[0], $item[1], $item[2]);
                }
            });
        }

        if (!empty($params['order'])) {
            foreach ($params['order'] as $order_k => $order_v) {
                $query = $query->orderBy($order_k, $order_v);
            }
        }

        return $query->get()->all();
    }
}
