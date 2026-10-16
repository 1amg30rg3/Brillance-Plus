<?php

namespace App\Http\Requests;

use App\Enums\CleaningFrequency;
use App\Enums\CleaningService;
use App\Enums\Locale;
use App\Enums\PropertyType;
use App\Enums\ServicePackage;
use App\Enums\TimeSlot;
use Illuminate\Contracts\Encryption\DecryptException;
use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Validation\Rule;
use Illuminate\Validation\Validator;

class StoreInquiryRequest extends FormRequest
{
    /**
     * The quote request form is public.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Default the contact language to the language the visitor is browsing in.
     */
    protected function prepareForValidation(): void
    {
        if (blank($this->input('preferred_language'))) {
            $this->merge(['preferred_language' => Locale::current()->value]);
        }
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'name' => ['required', 'string', 'min:2', 'max:120', 'not_regex:/[\x00-\x1F\x7F]/'],
            'email' => ['required', 'string', 'email', 'max:190'],
            'phone' => ['required', 'string', 'max:32', 'regex:/^\+?(?=(?:\D*\d){6,15}\D*$)[\d\s().\-]+$/'],
            'preferred_language' => ['required', Rule::enum(Locale::class)],
            'property_type' => ['required', Rule::enum(PropertyType::class)],
            'property_size' => ['nullable', 'integer', 'min:5', 'max:2000'],
            'rooms' => ['nullable', 'integer', 'min:1', 'max:30'],
            'service' => ['required', Rule::enum(CleaningService::class)],
            'package' => ['nullable', Rule::enum(ServicePackage::class)],
            'frequency' => ['required', Rule::enum(CleaningFrequency::class)],
            'preferred_date' => [
                'nullable',
                'date_format:Y-m-d',
                'after_or_equal:today',
                'before_or_equal:'.now()->addYear()->toDateString(),
            ],
            'preferred_time_slot' => ['nullable', Rule::enum(TimeSlot::class)],
            'message' => ['nullable', 'string', 'max:2000'],
            'privacy_consent' => ['accepted'],
            'website' => ['nullable', 'string'],
            'form_token' => ['nullable', 'string'],
        ];
    }

    /**
     * Reject submissions that fill the hidden honeypot field or arrive faster than a person could type.
     *
     * @return array<int, callable(Validator): void>
     */
    public function after(): array
    {
        return [
            function (Validator $validator): void {
                if (filled($this->input('website')) || $this->wasSubmittedTooQuickly()) {
                    $validator->errors()->add('form', (string) __('contact.errors.spam'));
                }
            },
        ];
    }

    /**
     * The attributes of the inquiry to store.
     *
     * @return array<string, mixed>
     */
    public function inquiryAttributes(): array
    {
        return [
            ...$this->safe()->except(['privacy_consent', 'website', 'form_token']),
            'privacy_consented_at' => now(),
        ];
    }

    /**
     * Determine whether the encrypted timestamp issued with the form is missing, forged or too recent.
     */
    private function wasSubmittedTooQuickly(): bool
    {
        try {
            $issuedAt = (int) Crypt::decryptString($this->string('form_token')->toString());
        } catch (DecryptException) {
            return true;
        }

        return now()->getTimestamp() - $issuedAt < (int) config('business.inquiries.minimum_fill_seconds');
    }
}
