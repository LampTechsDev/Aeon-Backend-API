<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use Illuminate\Support\HtmlString;

class EmailNotification extends Notification
{
    use Queueable;

    public $subject, $message, $cc, $page, $atachment_file;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct($subject, $message, $page = null, $cc = null, $atachment_file = null)
    {
        $this->subject      = $subject;
        $this->message      = $message;
        $this->cc           = $cc;
        $this->page         = $page;
        $this->atachment_file    = $atachment_file;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function via($notifiable)
    {
        return ['mail'];
    }

    /**
     * Get the mail representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return \Illuminate\Notifications\Messages\MailMessage
     */
    public function toMail($notifiable)
    {
        $mail_message = (new MailMessage)->subject($this->subject);
        if( !empty($this->cc) ){
            $mail_message->cc($this->cc);
        }
        if( !empty($this->page) ){
            if( !is_array($this->message) ){
                $this->message = [
                    "email_body"    => $this->message,
                ];
            }
            $mail_message->view($this->page, $this->message);
        }else{
            $mail_message->line(new HtmlString($this->message));
        }

        if( !empty($this->atachment_file) ){
            $mail_message->attach($this->atachment_file);
        }
        return $mail_message;
    }

    /**
     * Get the array representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function toArray($notifiable)
    {
        return [
            //
        ];
    }
}
