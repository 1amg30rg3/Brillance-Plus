<?php

namespace App\Services;

use App\Enums\Locale;
use App\Mail\InquiryConfirmation;
use App\Mail\InquiryReceived;
use App\Models\Inquiry;
use Illuminate\Mail\Mailable;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use Throwable;

/**
 * Sends the emails triggered by a new quote request.
 *
 * Email delivery never makes a saved inquiry fail: errors are logged with
 * the inquiry identifier only, without any personal data.
 */
class InquiryNotifier
{
    public function notify(Inquiry $inquiry): void
    {
        $this->notifyBusiness($inquiry);

        if (config('business.inquiries.send_customer_confirmation')) {
            $this->send($inquiry, $inquiry->email, (new InquiryConfirmation($inquiry))->locale($inquiry->preferred_language->value));
        }
    }

    private function notifyBusiness(Inquiry $inquiry): void
    {
        $recipient = config('business.inquiries.notification_email');

        if (! is_string($recipient) || blank($recipient)) {
            Log::warning('Quote request notification skipped: no notification email address is configured.', [
                'inquiry_id' => $inquiry->id,
            ]);

            return;
        }

        $this->send($inquiry, $recipient, (new InquiryReceived($inquiry))->locale(Locale::default()->value));
    }

    private function send(Inquiry $inquiry, string $recipient, Mailable $mailable): void
    {
        try {
            Mail::to($recipient)->send($mailable);
        } catch (Throwable $exception) {
            Log::error('A quote request email could not be sent.', [
                'inquiry_id' => $inquiry->id,
                'mailable' => $mailable::class,
                'exception' => $exception::class,
            ]);
        }
    }
}
