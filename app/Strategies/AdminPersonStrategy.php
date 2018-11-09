<?php

namespace App\Strategies;

use App\Models\Factory\Admin\Saas\SaasPersonFactory;

class AdminPersonStrategy extends AppStrategy
{
    /**
     * 通过主键 id 获取所有下级 id
     *
     * @param $id
     *
     * @return mixed
     */
    public static function getSubIdsById($id)
    {
        $saasPersons = SaasPersonFactory::getList();

        return self::getSubIds($id, $saasPersons);
    }

    /**
     * 获取下级人员id
     *
     * @param $id
     * @param $users
     *
     * @return array
     */
    private static function getSubIds($id, $users)
    {
        $ids = (array) $id;

        $children = array_filter($users, function ($val) use ($id) {
            return $val['create_id'] == $id;
        });

        foreach ($children as &$child) {
            $ids = array_merge($ids, self::getSubIds($child['id'], $users));
        }

        return $ids;
    }

    /**
     * 获取 person_ids 通过 user_id
     *
     * @param $userId
     *
     * @return array
     */
    public static function getPersonIdsByUserId($userId)
    {
        $saasId = SaasPersonFactory::getSaasAuthById($userId);

        return SaasPersonFactory::getAllPersonBySaasId($saasId);
    }

    /**
     * @param $userId
     *
     * @return mixed
     */
    public static function getPersonNameById($userId)
    {
        $person = SaasPersonFactory::getPersonInfo($userId);

        return $person->name ?: $person->username;
    }
}
