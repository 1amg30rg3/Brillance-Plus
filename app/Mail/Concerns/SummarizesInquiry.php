<?php

namespace App\Mail\Concerns;

use App\Models\Inquiry;

/**
 * Presents an inquiry as label / value rows, in the mailable's locale.
 */
trait SummarizesInquiry
{
    /**
     * @return array<string, string>
     */
    protected function inquirySummary(Inquiry $inquiry): array
    {
        $notSpecified = (string) __('mail.not_specified');

        $rows = [
            'name' => $inquiry->name,
            'email' => $inquiry->email,
            'phone' => $inquiry->phone,
            'preferred_language' => $inquiry->preferred_language->nativeName(),
            'property_type' => $inquiry->property_type->label(),
            'property_size' => $inquiry->property_size !== null
                ? (string) __('mail.size_value', ['size' => $inquiry->property_size])
                : $notSpecified,
            'rooms' => $inquiry->rooms !== null ? (string) $inquiry->rooms : $notSpecified,
            'service' => $inquiry->service->label(),
            'package' => $inquiry->package?->label() ?? $notSpecified,
            'frequency' => $inquiry->frequency->label(),
            'preferred_date' => $inquiry->preferred_date?->translatedFormat('l j F Y') ?? $notSpecified,
            'preferred_time_slot' => $inquiry->preferred_time_slot?->label() ?? $notSpecified,
            'message' => filled($inquiry->message) ? (string) $inquiry->message : $notSpecified,
        ];

        $summary = [];

        foreach ($rows as $field => $value) {
            $summary[(string) __("mail.labels.{$field}")] = $value;
        }

        return $summary;
    }
}
