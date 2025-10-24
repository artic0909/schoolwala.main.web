<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class WaiverMailBack extends Mailable
{
    use Queueable, SerializesModels;

    public $data;

    /**
     * Create a new message instance.
     */
    public function __construct($data)
    {
        $this->data = $data;
    }

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Schoolwala Waiver Update',
        );
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        return new Content(
            view: 'emails.waiver-mail-back-admin-side',
            with: [
                'p_name' => $this->data['p_name'],
                'c_name' => $this->data['c_name'],
                'email'  => $this->data['email'],
                'messageContent' => $this->data['messageContent'] ?? 'Your waiver request has been reviewed.',
            ],
        );
    }

    public function attachments(): array
    {
        return [];
    }
}
