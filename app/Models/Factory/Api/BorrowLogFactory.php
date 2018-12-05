<?php

namespace App\Models\Factory\Api;

use App\Models\Orm\BorrowLog;

class BorrowLogFactory extends ApiFactory
{
    public static function getBorrowLogDesc($userId)
    {
        $borrowLog = BorrowLog::select()
            ->where('user_id', '=', $userId)
            ->orderBy('create_at', 'desc')
            ->first();
        return $borrowLog ? $borrowLog->toArray() : [];
    }
}
