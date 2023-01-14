<?php

namespace App\Listeners;

use App\Events\AccountRegistration;
use App\Http\Components\Classes\Facade\TemplateMessage;
use App\Jobs\SendMail;
use App\Models\EmailTemplate;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class AccountSignupEmail
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
     * @param  \App\Events\AccountRegistration  $event
     * @return void
     */
    public function handle(AccountRegistration $event)
    {
        $user = $event->user;
        $email_template = "";
        switch ($event->user_type) {
            case 'therapist':
                $email_template =  EmailTemplate::where("email_type", "therapist_registration_confirmation")->orderBy("id", "DESC")->first();
                if( empty($email_template) ){
                    $email_template = $this->getDefaultTemplate();
                }
                break;
            case 'patient':    
                $email_template =  EmailTemplate::where("email_type", "patient_registration_confirmation")->orderBy("id", "DESC")->first();
                if( empty($email_template) ){
                    $email_template = $this->getDefaultTemplate();
                }
                break;
            default:
                $email_template = $this->getDefaultTemplate();
                break;
        }

        if( isset($email_template->template) && $email_template->mail_send ){
            $message = TemplateMessage::model($user)->parse($email_template->template);
            SendMail::dispatch($user, $email_template->subject, $message, $email_template->cc)->delay(1);
        }
    }

    /**
     * Load Default Template
     */
    public function getDefaultTemplate(){
        $email_template =  EmailTemplate::where("email_type", "signup_mail")->orderBy("id", "DESC")->first();
    }
}
