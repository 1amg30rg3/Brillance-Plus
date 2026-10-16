<?php

namespace App\Support;

use App\Enums\CleaningService;
use App\Enums\Locale;
use App\Enums\SitePage;

/**
 * Builds the search engine and social sharing metadata of a localized page.
 */
class PageMetadata
{
    /**
     * @return array{
     *     title: string,
     *     description: string,
     *     canonical: string,
     *     alternates: array<string, string>,
     *     defaultAlternate: string,
     *     paths: array<string, string>,
     *     image: string,
     *     siteName: string,
     *     openGraphLocale: string,
     *     openGraphAlternateLocales: list<string>,
     * }
     */
    public function for(SitePage $page, Locale $locale): array
    {
        $siteName = (string) config('business.name');

        $alternates = [];
        $paths = [];

        foreach (Locale::cases() as $alternateLocale) {
            $alternates[$alternateLocale->value] = $page->url($alternateLocale);
            $paths[$alternateLocale->value] = route($page->routeName($alternateLocale), absolute: false);
        }

        $prices = [
            'apartment' => $locale->formatEuros((int) CleaningService::Apartment->hourlyPriceFrom()),
            'house' => $locale->formatEuros((int) CleaningService::House->hourlyPriceFrom()),
        ];

        return [
            'title' => $this->translate("seo.pages.{$page->value}.title").' | '.$siteName,
            'description' => $this->translate("seo.pages.{$page->value}.description", $prices),
            'canonical' => $page->url($locale),
            'alternates' => $alternates,
            'defaultAlternate' => $page->url(Locale::default()),
            'paths' => $paths,
            'image' => rtrim((string) config('app.url'), '/').'/images/og-image.jpg',
            'siteName' => $siteName,
            'openGraphLocale' => $locale->openGraphLocale(),
            'openGraphAlternateLocales' => array_values(array_map(
                fn (Locale $other): string => $other->openGraphLocale(),
                array_filter(Locale::cases(), fn (Locale $other): bool => $other !== $locale),
            )),
        ];
    }

    /**
     * @param  array<string, string>  $replacements
     */
    private function translate(string $key, array $replacements = []): string
    {
        $line = __($key, $replacements);

        return is_string($line) ? $line : $key;
    }
}
