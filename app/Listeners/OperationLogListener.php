<?php

namespace App\Listeners;

use App\Events\OperationLogEvent;
use App\Models\Factory\Admin\Logs\SaasOperationLogFactory;

class OperationLogListener
{
    /**
     * OperationLogListener constructor.
     */
    public function __construct()
    {
    }

    /**
     * 存储 log
     * @param OperationLogEvent $event
     */
    public function handle(OperationLogEvent $event)
    {
        SaasOperationLogFactory::createLog($event->type, $event->content);
    }
}
