<?php

namespace App\Models\Factory\Admin\Order;

use App\Models\AbsModelFactory;
use App\Models\Orm\SaasOrderSaas;

class SaasOrderFactory extends AbsModelFactory
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
     * 通过 order_id 和 person_id 获取分单时间
     *
     * @param integer $orderId
     * @param array $personIds
     *
     * @return \Illuminate\Support\Collection
     */
    public static function getAssignedAtByOrderIdAndPersonIds($orderId, $personIds)
    {
        return SaasOrderSaas::where('order_id', $orderId)
            ->whereIn('person_id', $personIds)
            ->first()
            ->assigned_at;
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

    /**
     * 获取订单状态通过 id
     *
     * @param $id
     *
     * @return mixed
     */
    public static function getInfoById($id)
    {
        return SaasOrderSaas::find($id);
    }

    public static function getAll(array $params = [])
    {
        $query = new SaasOrderSaas();

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

    public static function getOne(array $params = [])
    {
        $query = new SaasOrderSaas();

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

        return $query->get()->first();
    }

    public static function insertGetId(array $insertData)
    {
        return SaasOrderSaas::insertGetId($insertData);
    }

    public static function update(array $where, array $set_data)
    {
        $query = new SaasOrderSaas();

        return $query->where($where)->update($set_data);
    }
}
