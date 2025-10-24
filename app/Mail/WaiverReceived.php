<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class WaiverReceived extends Mailable
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
            subject: 'New Waiver Form Received',
        );
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        return new Content(
            view: 'emails.waiver-mail-received',
            with: [
                'class_id' => $this->data['class_id'],
                'p_name' => $this->data['p_name'],
                'c_name' => $this->data['c_name'],
                'c_age' => $this->data['c_age'],
                'email' => $this->data['email'],
                'mobile' => $this->data['mobile'],
                'address' => $this->data['address'],
            ],
        );
    }

    public function attachments(): array
    {
        return [];
    }
}
