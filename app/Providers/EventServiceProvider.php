<?php

namespace App\Providers;

use App\Events\PasswordReset;
use App\Events\POCreationEvent;
use App\Listeners\BuyerPOCreationEmailSend;
use App\Listeners\ManufacturerPOCreationEmailSend;
use App\Listeners\PasswordResetEmailSend;
use App\Listeners\POCreationEmailSend;
use App\Listeners\VendorPOCreationEmailSend;
use Illuminate\Auth\Events\Registered;
use Illuminate\Auth\Listeners\SendEmailVerificationNotification;
use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Event;

class EventServiceProvider extends ServiceProvider
{
    /**
     * The event listener mappings for the application.
     *
     * @var array<class-string, array<int, class-string>>
     */
    protected $listen = [
        Registered::class => [
            SendEmailVerificationNotification::class,
        ],

        POCreationEvent::class => [
            POCreationEmailSend::class,
            VendorPOCreationEmailSend::class,
            ManufacturerPOCreationEmailSend::class,
            BuyerPOCreationEmailSend::class,
        ],

        PasswordReset::class => [
            PasswordResetEmailSend::class
        ],
    ];

    /**
     * Register any events for your application.
     *
     * @return void
     */
    public function boot()
    {
        //
    }
}
