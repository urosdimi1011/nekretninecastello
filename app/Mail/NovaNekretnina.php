<?php

namespace App\Mail;

use App\Models\Nekretnine;
use App\Models\Pretplatnik;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class NovaNekretnina extends Mailable
{
    use Queueable, SerializesModels;

    public function __construct(
        public Nekretnine $nekretnina,
        public Pretplatnik $pretplatnik
    ) {}

    public function envelope()
    {
        return new Envelope(
            subject: 'Nove nekretnine po vašim kriterijumima!',
        );
    }

    public function content()
    {
        return new Content(
            view: 'emails.nova-nekretnina',
        );
    }

    public function attachments()
    {
        return [];
    }
}
