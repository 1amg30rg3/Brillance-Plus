<?php

namespace App\Mail;

use App\Mail\Concerns\SummarizesInquiry;
use App\Models\Inquiry;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Address;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

/**
 * Notifies the business of a new quote request.
 */
class InquiryReceived extends Mailable
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
            replyTo: [new Address($this->inquiry->email, $this->inquiry->name)],
            subject: (string) __('mail.received.subject', ['name' => $this->inquiry->name]),
        );
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        return new Content(
            view: 'mail.inquiries.received',
            text: 'mail.inquiries.received-text',
            with: [
                'summary' => $this->inquirySummary($this->inquiry),
                'submittedAt' => $this->inquiry->created_at->translatedFormat('j F Y, H:i'),
                'agencyName' => config('agency.name'),
                'agencyUrl' => config('agency.url').'?'.http_build_query([
                    'utm_source' => 'brillance-plus.fr',
                    'utm_medium' => 'email',
                    'utm_campaign' => 'site-credit',
                ]),
            ],
        );
    }
}
