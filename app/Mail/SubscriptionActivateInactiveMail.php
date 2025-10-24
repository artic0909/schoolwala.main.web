<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class SubscriptionActivateInactiveMail extends Mailable
{
    use Queueable, SerializesModels;

    public $mailData;

    /**
     * Create a new message instance.
     */
    public function __construct($mailData)
    {
        $this->mailData = $mailData;
    }

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        $subject = $this->mailData['status'] == 'active' 
            ? '🎉 Subscription Activated - Welcome to Schoolwala!' 
            : 'Subscription Update - Schoolwala';

        return new Envelope(
            subject: $subject,
        );
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        return new Content(
            view: 'emails.subscription-active-inactive-mail',
            with: [
                'status' => $this->mailData['status'],
                'student_name' => $this->mailData['student_name'],
                'class_name' => $this->mailData['class_name'],
                'class_id' => $this->mailData['class_id'],
                'subject_id' => $this->mailData['subject_id'],
                'subscription_date' => $this->mailData['subscription_date'],
                'expiry_date' => $this->mailData['expiry_date'] ?? null,
            ]
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