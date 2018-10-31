<?php

namespace App\Models\Factory\Admin\Order;

use App\Models\AbsModelFactory;
use App\Models\Orm\UserOrderBasicInfo;

class OrderBasicInfoFactory extends AbsModelFactory
{
    /**
     * @param $params
     *
     * @return $this|\Illuminate\Database\Eloquent\Model
     */
    public static function create($params)
    {
        return UserOrderBasicInfo::create($params);
    }

    /**
     * @param $id
     *
     * @return mixed|static
     */
    public static function getById($id)
    {
        return UserOrderBasicInfo::find($id);
    }

    /**
     * 根据不同筛选条件查询多条数据
     * @param array $params
     * @return array
     */
    public static function getAll(array $params = [])
    {
        $query = new UserOrderBasicInfo();

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
