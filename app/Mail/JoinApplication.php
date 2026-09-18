<?php

namespace App\Mail;

use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Address;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;

class JoinApplication extends Mailable
{
    /**
     * @param  array<string, string>  $payload
     */
    public function __construct(public array $payload) {}

    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Nieuwe lidkandidatuur — '.$this->payload['voornaam'].' '.$this->payload['naam'],
            replyTo: [
                new Address($this->payload['email'], $this->payload['voornaam'].' '.$this->payload['naam']),
            ],
        );
    }

    public function content(): Content
    {
        return new Content(
            markdown: 'mail.join-application',
        );
    }
}
