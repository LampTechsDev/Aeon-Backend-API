<?php

namespace App\Listeners;

use App\Events\ShippingBooked;
use App\Http\Components\Classes\Facade\TemplateMessage;
use App\Jobs\SendMail;
use App\Models\EmailTemplate;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class VendorShippingBookedMailSend
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
     * @param  \App\Events\ShippingBooked  $event
     * @return void
     */
    public function handle(ShippingBooked $event)
    {
        $model = $event->model;
        $user = $model->criticalPathInfo->poId->vendor;
        $email_template = "";
        $email_template =  EmailTemplate::where("email_type", "vendor_shipping_booking_done_mail")->orderBy("id", "DESC")->first();

        if( isset($email_template->template) && $email_template->mail_send ){
            $message = TemplateMessage::model($model)->parse($email_template->template);
            $message = TemplateMessage::model($user)->parse($message);
            SendMail::dispatch($user, $email_template->subject, $message, $email_template->cc)->delay(1);
        }
    }
}
