<?php

namespace App\Jobs;

use App\Mail\PostMail;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Mail;

class SendEmailJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $postMail;

    /**
     * Create a new job instance.
     */
    public function __construct($postMail)
    {
        $this->postMail = $postMail;
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {   

        Mail::to($this->postMail['email'])->send(new PostMail([
            'title' => $this->postMail['title'],
            'body' => $this->postMail['body'],
        ]));
    }
}
