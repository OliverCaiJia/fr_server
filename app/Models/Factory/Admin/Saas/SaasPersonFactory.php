<?php

namespace App\Models\Factory\Admin\Saas;

use App\Constants\SaasConstant;
use App\Models\AbsModelFactory;
use App\Models\Orm\AdminPersons;
use Hash;

class SaasPersonFactory extends AbsModelFactory
{
    /**
     * 获取 saas 用户 ID 根据 saas 人员 ID
     *
     * @param $personId
     *
     * @return int|mixed
     */
    public static function getSaasAuthById($personId)
    {
        $person = AdminPersons::select('saas_auth_id')->find($personId);

        return $person ? $person->saas_auth_id : 0;
    }

    /**
     * 通过person_id获取该人手下所有人员（未删除）
     * @param $psnId
     * @return array
     */
    public static function getAllPersonByPersonId($psnId)
    {
        return AdminPersons::where([
            'create_id' => $psnId,
            'is_deleted' => SaasConstant::SAAS_USER_DELETED_FALSE
        ])->get()->toArray();
    }

    /**
     * 获取全部管理员
     *
     * @return \Illuminate\Database\Eloquent\Collection|static[]
     */
    public static function getList()
    {
        return AdminPersons::select('id', 'create_id')->get()->toArray();
    }

    /**
     * 通过saas_id获取所有person_id
     * @param $saasId
     * @return array
     */
    public static function getAllPersonBySaasId($saasId)
    {
        $personIds = AdminPersons::where([
            'saas_auth_id' => $saasId,
            'is_deleted' => SaasConstant::SAAS_USER_DELETED_FALSE
        ])->pluck('id');
        return $personIds ? $personIds->toArray() : [];
    }

    /**
     * 获取saas人员信息
     * @param $personId
     * @return \Illuminate\Database\Eloquent\Model|null|object|static
     */
    public static function getPersonInfo($personId)
    {
        return AdminPersons::whereKey($personId)->first();
    }

    /**
     * 修改密码
     * @param $personId
     * @param $newPsw
     * @return bool
     */
    public static function changePsw($personId, $newPsw)
    {
        return AdminPersons::whereKey($personId)->update([
            'password' => Hash::make($newPsw)
        ]);
    }

    /**
     * 通过人员ID获取该人员第一个角色的名称
     * @param $perosnId
     * @return string
     */
    public static function getFirstRoleById($perosnId)
    {
        return AdminPersons::whereKey($perosnId)->first()->roles()->value('name') ?? '';
    }
}
