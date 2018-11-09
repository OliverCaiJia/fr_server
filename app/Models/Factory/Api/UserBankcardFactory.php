<?php

namespace App\Models\Factory;

use App\Models\Factory\Api\ApiFactory;
use App\Models\Orm\UserBankcard;

/**
 * Class BanksFactory
 * @package App\Models\Factory
 * 银行卡工厂
 */
class UserBankcardFactory extends ApiFactory
{
    /**
     * @return bool
     * 添加银行卡
     */
    public static function userBankAdd($data)
    {
        $addBank = UserBankcard::save($data);

        return $addBank;
    }

    /**
     * @param $bank_id
     * @return bool
     * 删除银行卡
     */
    public static function userBankDelete($bank_id)
    {
        $deleteBank = UserBankcard::delete()
            ->where(['id' => $bank_id]);

        return $deleteBank;
    }

    /**
     * @param $user_id
     * @return array
     * 银行卡列表
     */
    public static function userBankList($user_id)
    {
        $bankList = UserBankcard::select(['id', 'user_id', 'bank_card_no', 'bank_card_type','is_default','bank_card_mobile'])
            ->where(['user_id' =>$user_id])
            ->get()
            ->toArray();

        return $bankList;
    }

    /**
     * @param $bank_card_no 银行卡号
     * @return array
     * 获取指定银行卡
     */
    public static function userBankFirst($bank_card_no)
    {
        $bankFirst = Bank::select()
            ->where(['bank_card_no' => $bank_card_no])
            ->first();

        return $bankFirst;
    }

    /**
     * @param $id 主键id
     * @param $is_default 是否默认 0不是，1是
     * @return int
     * 更改默认值
     */
    public static function userBankUpdate($id,$is_default)
    {
        $bankUpdate = UserBankcard::where(['id' => $id])
            ->update(['is_default' => $is_default]);

        return $bankUpdate;
    }
}