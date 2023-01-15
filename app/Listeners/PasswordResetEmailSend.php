<?php

namespace App\Listeners;

use App\Http\Components\Classes\Facade\TemplateMessage;
use App\Jobs\SendMail;
use App\Models\EmailTemplate;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class PasswordResetEmailSend
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
     * @param  object  $event
     * @return void
     */
    public function handle($event)
    {
        $password_reset = $event->password_reset;
        $after_reset = $event->after_reset;
        $user = $password_reset->user;
        
        if($after_reset){
            $this->sentPasswordResetNotification($user);
        }else{
            $this->sentPasswordResetCode($password_reset, $user);
        }
    }

    /**
     * Send Password Reset Verification Code
     */
    protected function sentPasswordResetCode($password_reset, $user){
        $email_template = EmailTemplate::where("email_type", "password_reset")->orderBy("id", "DESC")->first();
        if( isset($email_template->template) && $email_template->mail_send){
            if( !isset($user->first_name) ){
                $user->first_name = $user->name;
                $user->last_name = "";
            }
            $message = TemplateMessage::model($user)->parse($email_template->template);
            $message = TemplateMessage::model($password_reset)->parse($message);
            SendMail::dispatch($user, $email_template->subject, $message, $email_template->cc)->delay(1);
        }else{
            $message = "Your Password Reset Verification Code is: ". $password_reset->token;
            SendMail::dispatch($user, "Password Reset", $message)->delay(1);
        }
    }

    /**
     * Sent Notification Email After Reset Password
     */
    protected function sentPasswordResetNotification($user){
        $email_template = "";
        if($user->getMorphClass() == "App\Models\Admin"){
            $email_template = EmailTemplate::where("email_type", "admin_password_change")->orderBy("id", "DESC")->first();
        }
        elseif($user->getMorphClass() == "App\Models\User"){
            $email_template = EmailTemplate::where("email_type", "patient_password_change")->orderBy("id", "DESC")->first();
        }else{
            $email_template = EmailTemplate::where("email_type", "therapist_password_change")->orderBy("id", "DESC")->first();
        }
        
        if( isset($email_template->template) && $email_template->mail_send){
            if( !isset($user->first_name) ){
                $user->first_name = $user->name;
                $user->last_name = "";
            }
            $message = TemplateMessage::model($user)->parse($email_template->template);
            SendMail::dispatch($user, $email_template->subject, $message, $email_template->cc)->delay(1);
        }
    }
}
