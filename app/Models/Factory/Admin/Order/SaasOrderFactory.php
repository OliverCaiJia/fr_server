<?php

namespace App\Models\Factory\Admin\Order;

use App\Models\AbsBaseModel;
use App\Models\Orm\SaasOrderSaas;

class SaasOrderFactory extends AbsBaseModel
{
    /**
     * 更新订单状态
     *
     * @param $id
     * @param $status
     *
     * @return bool
     */
    public static function updateStatus($id, $status)
    {
        return SaasOrderSaas::where('id', $id)->update(['status' => $status]);
    }

    /**
     * 通过 order_id 和 person_id 获取主键 id
     *
     * @param $orderId
     * @param $personId
     *
     * @return \Illuminate\Support\Collection
     */
    public static function getIdByOrderIdAndPersonId($orderId, $personId)
    {
        return SaasOrderSaas::where('order_id', $orderId)
            ->where('person_id', $personId)
            ->first()
            ->id;
    }

    /**
     * 通过 order_id 和 person_id 获取status
     *
     * @param integer $orderId
     * @param array $personIds
     *
     * @return \Illuminate\Support\Collection
     */
    public static function getStatusByOrderIdAndPersonIds($orderId, $personIds)
    {
        return SaasOrderSaas::where('order_id', $orderId)
            ->whereIn('person_id', $personIds)
            ->first()
            ->status;
    }

    /**
     * 根据 where 条件更新 person_id
     *
     * @param array $where
     * @param int $personId
     *
     * @return bool
     */
    public static function updateSaasAuthPersonId($where, $personId)
    {
        return SaasOrderSaas::where($where)->update(['person_id' => $personId]);
    }

    /**
     * 获取订单状态通过 id
     *
     * @param $id
     *
     * @return mixed
     */
    public static function getOrderStatusById($id)
    {
        return SaasOrderSaas::find($id)->status;
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
        return SaasOrderSaas::where('person_id', $personId)->first();
    }
}
