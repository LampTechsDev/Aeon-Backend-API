<?php

namespace App\Jobs;

use App\Notifications\EmailNotification;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class SendMail implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $model;
    protected $subject;
    protected $message;
    protected $page;
    protected $cc;
    protected $invoice_pdf;
    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($model, $subject, $message, $cc = "", $invoice_pdf = null, $page = "email.default")
    {
        $this->model    = $model;
        $this->subject  = $subject;
        $this->message  = $message;
        $this->cc       = $cc;
        $this->page     = $page;
        $this->invoice_pdf = $invoice_pdf;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $this->model->notify(New EmailNotification($this->subject, $this->message, $this->page, $this->cc, $this->invoice_pdf));
    }
}
