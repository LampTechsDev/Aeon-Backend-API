<?php

namespace App\Listeners;

use App\Events\POCreationEvent;
use App\Http\Components\Classes\Facade\TemplateMessage;
use App\Jobs\SendMail;
use App\Models\Admin;
use App\Models\EmailTemplate;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class POCreationEmailSend
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
        $po = $event->po;
        $admins = Admin::where("email_receive_status", true)->get();
        $email_template = "";
        $email_template =  EmailTemplate::where("email_type", "therapist_registration_confirmation")->orderBy("id", "DESC")->first();

        if( isset($email_template->template) && $email_template->mail_send ){
            $message = TemplateMessage::model($po)->parse($email_template->template);
            foreach($admins as $user){
                SendMail::dispatch($user, $email_template->subject, $message, $email_template->cc)->delay(1);
            }
        }
    }
}
