<?php

namespace App\Providers;

use App\Events\CriticalPath;
use App\Events\InvoiceSubmitted;
use App\Events\PasswordReset;
use App\Events\POCreationEvent;
use App\Events\ScheduleCreated;
use App\Events\ShippingBooked;
use App\Listeners\BuyerInvoiceSubmitedMailSend;
use App\Listeners\BuyerPOCreationEmailSend;
use App\Listeners\BuyerShippingBookedMailSend;
use App\Listeners\CriticalPathMailSend;
use App\Listeners\InvoiceSubmitedMailSend;
use App\Listeners\ManufacturerCriticalPathMailSend;
use App\Listeners\ManufacturerPOCreationEmailSend;
use App\Listeners\ManufacturerScheduleCreateMailSend;
use App\Listeners\PasswordResetEmailSend;
use App\Listeners\POCreationEmailSend;
use App\Listeners\ScheduleCreateMailSend;
use App\Listeners\ShippingBookedMailSend;
use App\Listeners\VendorCriticalPathMailSend;
use App\Listeners\VendorInvoiceSubmitedMailSend;
use App\Listeners\VendorPOCreationEmailSend;
use App\Listeners\VendorScheduleCreateMailSend;
use App\Listeners\VendorShippingBookedMailSend;
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
        PasswordReset::class => [
            PasswordResetEmailSend::class
        ],

        POCreationEvent::class => [
            POCreationEmailSend::class,
            VendorPOCreationEmailSend::class,
            ManufacturerPOCreationEmailSend::class,
            BuyerPOCreationEmailSend::class,
        ],
        CriticalPath::class => [
            CriticalPathMailSend::class,
            VendorCriticalPathMailSend::class,
            ManufacturerCriticalPathMailSend::class
        ],
        InvoiceSubmitted::class => [
            InvoiceSubmitedMailSend::class,
            BuyerInvoiceSubmitedMailSend::class,
            VendorInvoiceSubmitedMailSend::class,
        ],
        ShippingBooked::class => [
            ShippingBookedMailSend::class,
            BuyerShippingBookedMailSend::class,
            VendorShippingBookedMailSend::class,
        ],
        ScheduleCreated::class => [
            ScheduleCreateMailSend::class,
            VendorScheduleCreateMailSend::class,
            ManufacturerScheduleCreateMailSend::class
        ]

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
