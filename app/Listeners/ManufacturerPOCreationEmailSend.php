<?php

namespace App\Listeners;

use App\Events\POCreationEvent;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class ManufacturerPOCreationEmailSend
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
     * @param  \App\Events\POCreationEvent  $event
     * @return void
     */
    public function handle(POCreationEvent $event)
    {
        //
    }
}
