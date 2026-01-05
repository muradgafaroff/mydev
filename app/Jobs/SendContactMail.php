<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Mail;

class SendContactMail implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $data;

    public function __construct($data)
    {
        $this->data = $data;
    }

    public function handle(): void
    {
        Mail::raw("Yeni mesaj: " . $this->data['message'], function ($message) {
            $message->to('muradgafaroff@mydev.az')
                    ->subject("Müraciət: " . $this->data['subject'])
                    ->from($this->data['email'], $this->data['name']);
        });
    }
}
