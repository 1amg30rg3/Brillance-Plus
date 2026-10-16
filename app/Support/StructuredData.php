<?php

namespace App\Support;

use App\Enums\CleaningService;
use App\Enums\Locale;
use App\Enums\SitePage;

/**
 * Builds the Schema.org JSON-LD graph describing the business.
 *
 * Only verified facts are included: no address, opening hours, service area
 * or ratings are published until the business provides them.
 */
class StructuredData
{
    /**
     * @return array<string, mixed>
     */
    public function for(Locale $locale): array
    {
        $baseUrl = rtrim((string) config('app.url'), '/');
        $email = config('business.email');

        $business = array_filter([
            '@type' => 'LocalBusiness',
            '@id' => "{$baseUrl}/#business",
            'name' => config('business.name'),
            'url' => SitePage::Home->url($locale),
            'logo' => "{$baseUrl}/apple-touch-icon.png",
            'image' => "{$baseUrl}/images/og-image.jpg",
            'description' => __('seo.site_description'),
            'telephone' => config('business.phone'),
            'email' => filled($email) ? $email : null,
            'makesOffer' => $this->offers(),
        ]);

        return [
            '@context' => 'https://schema.org',
            '@graph' => [
                $business,
                [
                    '@type' => 'WebSite',
                    '@id' => "{$baseUrl}/#website",
                    'url' => SitePage::Home->url($locale),
                    'name' => config('business.name'),
                    'inLanguage' => $locale->value,
                    'publisher' => ['@id' => "{$baseUrl}/#business"],
                    'creator' => $this->creator(),
                ],
            ],
        ];
    }

    /**
     * The agency that designed and built the website.
     *
     * @return array<string, mixed>
     */
    private function creator(): array
    {
        return [
            '@type' => 'Organization',
            'name' => config('agency.name'),
            'url' => config('agency.url'),
            'logo' => config('agency.logo'),
            'founder' => [
                '@type' => 'Person',
                'name' => config('agency.founder'),
            ],
        ];
    }

    /**
     * @return list<array<string, mixed>>
     */
    private function offers(): array
    {
        $offers = [];

        foreach (CleaningService::cases() as $service) {
            $price = $service->hourlyPriceFrom();

            if ($price === null) {
                continue;
            }

            $offers[] = [
                '@type' => 'Offer',
                'itemOffered' => [
                    '@type' => 'Service',
                    'name' => $service->label(),
                ],
                'priceSpecification' => [
                    '@type' => 'UnitPriceSpecification',
                    'minPrice' => $price,
                    'priceCurrency' => config('business.pricing.currency'),
                    'unitCode' => 'HUR',
                ],
            ];
        }

        return $offers;
    }
}
