<?php

namespace App\Providers;

use Illuminate\Support\Facades\Event;
use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;

class EventServiceProvider extends ServiceProvider
{
    /**
     * The event listener mappings for the application.
     *
     * @var array
     */
    protected $listen = [

        'App\Events\V1\UserLoginEvent' => [
            'App\Listeners\V1\UserLoginListener',
        ],
        'App\Events\V1\UserRegEvent' => [
            'App\Listeners\V1\UserRegCreditListener',
            'App\Listeners\V1\UserRegNoticeListener',
            'App\Listeners\V1\UserRegCountListener',
        ],

        'App\Events\Event' => [
            'App\Listeners\EventListener',
        ],
        'App\Events\OrderActionEvent' => [
            'App\Listeners\OrderActionListener',
        ],
        'App\Events\OperationLogEvent' => [
            'App\Listeners\OperationLogListener',
        ],
    ];

    /**
     * Register any events for your application.
     *
     * @return void
     */
    public function boot()
    {
        parent::boot();

        //
    }
}
