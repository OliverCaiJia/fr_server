<?php

namespace App\Helpers\Logger;

use Monolog\Logger as MonologLogger;
use Monolog\Handler\NativeMailerHandler;
use Monolog\Processor\WebProcessor;

class MailLogger
{

    private static $nativeMailer;

    /*
     * NativeMailer
     */

    public static function getMailer()
    {
        if (!(self::$nativeMailer instanceof MonologLogger)) {
            self::$nativeMailer = new MonologLogger('jdt');
            self::$nativeMailer->pushHandler(self::getNativeMailerHandler());
            self::$nativeMailer->pushProcessor(new WebProcessor());
        }
        return self::$nativeMailer;
    }

    private static function getNativeMailerHandler()
    {
        $handler = new NativeMailerHandler('tech-report@jdt.com', 'JDT-Log', 'tech-report@jdt.com');
        return $handler;
    }

}
