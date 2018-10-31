<?php

namespace App\Models\Factory\Admin\Logs;

use App\Constants\SaasOperationLogConstant;
use App\Models\AbsBaseModel;
use App\Models\Orm\SaasOperationLog;
use Auth;

class SaasOperationLogFactory extends AbsBaseModel
{
    /**
     * 创建操作履历
     * @param $type
     * @param string $extra
     * @return $this|bool|\Illuminate\Database\Eloquent\Model
     */
    public static function createLog($type, $extra = '')
    {
        if (!isset(SaasOperationLogConstant::SAAS_OPERATION_TYPE[$type])) {
            return false;
        }

        $info = SaasOperationLogConstant::SAAS_OPERATION_TYPE[$type];

        if (!empty($extra)) {
            $info['remark'] .= ',';
        }

        $data = [
            'type' => $type,
            'operator_id' => Auth::user()->id,
            'operator_name' => Auth::user()->username,
            'content' => $info['remark'] . $extra,
        ];

        return SaasOperationLog::create($data);
    }
}
