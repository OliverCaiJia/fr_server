<?php

namespace App\Strategies;

use Gate;

class PermissionStrategy extends AppStrategy
{
    /**
     * 创建菜单树
     *
     * @param array $data
     * @param int   $parent_id
     *
     * @return array
     */
    public static function generateTree($data, $parent_id = 0)
    {
        $tmp = [];
        foreach ($data as $key => $item) {
            if ($item['parent_id'] == $parent_id) {
                foreach ($data as $k => $value) {
                    if ($value['parent_id'] == $item['id'] && Gate::check($value['name'])) {
                        $item['children'][] = $value;
                    }
                }
                if (isset($item['children'])) {
                    $tmp[] = $item;
                }
            }
        }

        return $tmp;
    }
}
