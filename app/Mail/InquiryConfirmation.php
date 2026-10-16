<?php

namespace App\Mail;

use App\Mail\Concerns\SummarizesInquiry;
use App\Models\Inquiry;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

/**
 * Confirms to the customer that their quote request has been received.
 */
class InquiryConfirmation extends Mailable
{
    use Queueable, SerializesModels, SummarizesInquiry;

    /**
     * Create a new message instance.
     */
    public function __construct(public Inquiry $inquiry) {}

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        return new Envelope(
            subject: (string) __('mail.confirmation.subject'),
        );
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        return new Content(
            view: 'mail.inquiries.confirmation',
            text: 'mail.inquiries.confirmation-text',
            with: [
                'summary' => $this->inquirySummary($this->inquiry),
            ],
        );
    }
}
