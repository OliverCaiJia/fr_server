<?php

namespace App\Helpers\Logger;

use Request;
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
            self::$logger = new MonologLogger('jdt-stream');
            self::$logger->pushHandler(self::getStreamHandler());
            self::$logger->pushProcessor(new WebProcessor(null, $extraFields));

            //添加请求参数到日志
            self::$logger->pushProcessor(function ($record) {
                $record['extra']['request'] = Request::all();
                return $record;
            });
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
        $logpath = storage_path() . '/logs/saas.jt-' . date('Y-m-d') . '.log';
        $handler = new StreamHandler($logpath, MonologLogger::INFO, true, 0777);
        $lineFormatter = new LineFormatter();
        $lineFormatter->includeStacktraces(true);
        $handler->setFormatter($lineFormatter);

        return $handler;
    }
}
