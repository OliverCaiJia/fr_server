<?php

namespace App\Helpers\Logger;

use Monolog\Formatter\LineFormatter;
use Monolog\Logger as MonologLogger;
use Monolog\Handler\StreamHandler;
use Monolog\Processor\WebProcessor;

class SLogger
{

    private static $logger;

    public static function i()
    {
        return self::getStream();
    }

    /**
     * 文件日志
     *
     * @return \Monolog\Logger
     * @throws \Exception
     */
    public static function getStream()
    {
        if (!(self::$logger instanceof MonologLogger)) {
            $extraFields = [
                'url' => 'REQUEST_URI',
                'ip' => 'REMOTE_ADDR',
                'http_method' => 'REQUEST_METHOD',
                'server' => 'SERVER_NAME',
                'referrer' => 'HTTP_REFERER',
                'ua' => 'HTTP_USER_AGENT',
                'query' => 'QUERY_STRING',
                'ser_ip' => 'SERVER_ADDR'
            ];
            self::$logger = new MonologLogger('sdjt-stream');
            self::$logger->pushHandler(self::getStreamHandler());
            self::$logger->pushProcessor(new WebProcessor(null, $extraFields));
            self::$logger->setTimezone(new \DateTimeZone('PRC'));
        }
        return self::$logger;
    }

    /**
     * 处理器
     *
     * @return \Monolog\Handler\StreamHandler
     * @throws \Exception
     */
    private static function getStreamHandler()
    {
        $logpath = storage_path() . '/logs/saas.jietiao-' . date('Y-m-d') . '.log';
        $handler = new StreamHandler($logpath, MonologLogger::INFO, true, 0777);
        $lineFormatter = new LineFormatter();
        $lineFormatter->includeStacktraces(true);
        $handler->setFormatter($lineFormatter);

        return $handler;
    }
}
