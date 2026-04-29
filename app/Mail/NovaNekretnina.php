<?php

namespace App\Mail;

use App\Models\PretplatnikFilter;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Collection;

class NovaNekretnina extends Mailable
{
    use Queueable, SerializesModels;

    public function __construct(
        public Collection        $nekretnine,
        public PretplatnikFilter $filter
    ) {}

    public function envelope()
    {
        $count = $this->nekretnine->count();
        $naziv = $count === 1 ? 'Nova nekretnina' : "{$count} nove nekretnine";
        return new Envelope(
            subject: "$naziv po vašim kriterijumima – Castello Nekretnine",
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
