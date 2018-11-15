<?php

namespace App\Models\Factory;

use App\Models\Factory\Api\ApiFactory;
use App\Models\Orm\Fee;

/**
 * Class BanksFactory
 * @package App\Models\Factory
 * 费用信息工厂
 */
class FeeFactory extends ApiFactory
{
    /**
     * @param $fee_type_id
     * @return array
     * 根据类型id获取费用信息列表
     */
    public static function getFeeListByTypeId($fee_type_id)
    {
        $feeList = Fee::select(['id','fee_type_nid','seq_no','name','price','old_price'])
            ->where([['fee_type_id',$fee_type_id],['is_delete',0]])
            ->get();

        return $feeList ? $feeList->toArray() : [];
    }

    /**
     * @param $fee_type_id
     * @return array
     * 根据类型id获取指定类型费用信息
     */

    public static function getFeeByTypeId($fee_type_id)
    {
        $feeList = Fee::select(['id','fee_type_nid','seq_no','name','price','old_price'])
            ->where([['fee_type_id',$fee_type_id],['is_delete',0]])
            ->first();

        return $feeList ? $feeList->toArray() : [];
    }

    /**
     * @param $fee_type_nid
     * @return array
     *根据类型标识获取费用信息列表
     */

    public static function getFeeListByTypeNid($fee_type_nid)
    {
        $feeList = Fee::select(['id','fee_type_nid','seq_no','name','price','old_price'])
            ->where([['fee_type_nid',$fee_type_nid],['is_delete',0]])
            ->get();

        return $feeList ? $feeList->toArray() : [];
    }

    /**
     * @param $fee_type_nid
     * @return array
     * 根据标识获取费用信息
     */

    public static function getFeeByFeeNid($fee_nid)
    {
        $feeList = Fee::where('fee_nid','=',$fee_nid)->first();

        return $feeList ? $feeList->toArray() : [];
    }

}