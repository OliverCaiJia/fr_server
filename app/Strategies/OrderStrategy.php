<?php
namespace App\Strategies;

use Carbon\Carbon;
use Medz\IdentityCard\China\Identity;

class OrderStrategy extends AppStrategy
{
    /**
     * 
     *
     * @param 
     *
     * @return string
     */
    public static function doOrder($data)
    {
        $type = $data['type'];
        switch($type)
        {
            case "EXTRA":
                // new Handler 
                // doAction
                break;
            case "REPORT":
                // new Handler 
                // doAction
                break;
            default:
                break;
        }
        return $res;
    }
}
