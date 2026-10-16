<?php

namespace App\Support;

use App\Enums\CleaningService;
use App\Enums\Locale;
use App\Enums\SitePage;
use Carbon\CarbonImmutable;

/**
 * Assembles a legal document (privacy policy, legal notice, terms) from its
 * translation file, filling in the configured business details.
 *
 * Details that have not been configured are rendered as "to be completed"
 * so the site never displays invented legal information.
 */
class LegalDocument
{
    /**
     * @return array{
     *     eyebrow: string,
     *     relatedTitle: string,
     *     title: string,
     *     intro: string,
     *     updatedAt: string,
     *     sections: list<array{heading: string, paragraphs?: list<string>, list?: list<string>, after?: list<string>}>,
     * }
     */
    public function for(SitePage $page, Locale $locale): array
    {
        /** @var array{title: string, intro: string, sections: list<array{heading: string, paragraphs?: list<string>, list?: list<string>, after?: list<string>}>} $document */
        $document = __("legal.{$page->value}", $this->replacements($locale));

        $updatedAt = CarbonImmutable::parse((string) config('business.legal.documents_updated_at'))
            ->settings(['locale' => $locale->value])
            ->translatedFormat('j F Y');

        return [
            'eyebrow' => (string) __('legal.eyebrow'),
            'relatedTitle' => (string) __('legal.related'),
            'title' => $document['title'],
            'intro' => $document['intro'],
            'updatedAt' => (string) __('legal.updated_at', ['date' => $updatedAt]),
            'sections' => $document['sections'],
        ];
    }

    /**
     * @return array<string, string>
     */
    private function replacements(Locale $locale): array
    {
        $phone = (string) config('business.phone_display');
        $email = config('business.email');

        $contact = filled($email)
            ? __('legal.contact_phone_and_email', ['phone' => $phone, 'email' => $email])
            : __('legal.contact_phone', ['phone' => $phone]);

        return [
            'site' => (string) parse_url((string) config('app.url'), PHP_URL_HOST),
            'company_name' => $this->configured('business.legal.company_name'),
            'legal_form' => $this->configured('business.legal.legal_form'),
            'address' => $this->configured('business.legal.address'),
            'registration_number' => $this->configured('business.legal.registration_number'),
            'vat_number' => $this->configured('business.legal.vat_number'),
            'publication_director' => $this->configured('business.legal.publication_director'),
            'host' => $this->configured('business.legal.host'),
            'mediator' => $this->configured('business.legal.consumer_mediator'),
            'email' => $this->configured('business.email'),
            'phone' => $phone,
            'contact' => (string) $contact,
            'retention_years' => (string) config('business.inquiries.retention_years'),
            'apartment' => $locale->formatEuros((int) CleaningService::Apartment->hourlyPriceFrom()),
            'house' => $locale->formatEuros((int) CleaningService::House->hourlyPriceFrom()),
        ];
    }

    private function configured(string $key): string
    {
        $value = config($key);

        return filled($value) ? (string) $value : (string) __('legal.to_complete');
    }
}
