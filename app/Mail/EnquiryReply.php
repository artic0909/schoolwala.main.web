<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class EnquiryReply extends Mailable
{
    use Queueable, SerializesModels;

    public $replyMessage;
    public $replySubject;
    public $enquiryName;

    /**
     * Create a new message instance.
     */
    public function __construct($replyMessage, $replySubject, $enquiryName = null)
    {
        $this->replyMessage = $replyMessage;
        $this->replySubject = $replySubject;
        $this->enquiryName = $enquiryName;
    }

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        return new Envelope(
            subject: $this->replySubject,
        );
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        return new Content(
            view: 'emails.reply-enquiry-mail',
        );
    }

    /**
     * Get the attachments for the message.
     *
     * @return array<int, \Illuminate\Mail\Mailables\Attachment>
     */
    public function attachments(): array
    {
        return [];
    }
}
