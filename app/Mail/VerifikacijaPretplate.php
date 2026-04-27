<?php

namespace App\Mail;

use App\Models\Pretplatnik;
use App\Models\PretplatnikFilter;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class VerifikacijaPretplate extends Mailable
{
    use Queueable, SerializesModels;


    public function __construct(
        public Pretplatnik $pretplatnik,
        public PretplatnikFilter $filter
    ) {}



    public function envelope()
    {
        return new Envelope(
            subject: 'Verifikacija Pretplate',
        );
    }


    public function content()
    {
        return new Content(
            view: 'emails.verifikacija-pretplate',
        );
    }

    public function attachments()
    {
        return [];
    }
}
