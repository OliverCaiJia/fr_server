<?php

namespace App\Listeners\V1;

use App\Events\V1\UserRegEvent;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

class UserRegCountListener
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     *
     * @param  UserRegEvent  $event
     * @return void
     */
    public function handle(UserRegEvent $event)
    {
        //
    }
}
