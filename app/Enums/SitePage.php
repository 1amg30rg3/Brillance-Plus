<?php

namespace App\Enums;

enum SitePage: string
{
    case Home = 'home';
    case Services = 'services';
    case Pricing = 'pricing';
    case HowItWorks = 'how_it_works';
    case About = 'about';
    case Contact = 'contact';
    case PrivacyPolicy = 'privacy_policy';
    case LegalNotice = 'legal_notice';
    case Terms = 'terms';

    /**
     * The Inertia page component rendering this page.
     */
    public function component(): string
    {
        return match ($this) {
            self::Home => 'Home',
            self::Services => 'Services',
            self::Pricing => 'Pricing',
            self::HowItWorks => 'HowItWorks',
            self::About => 'About',
            self::Contact => 'Contact',
            self::PrivacyPolicy, self::LegalNotice, self::Terms => 'Legal',
        };
    }

    /**
     * Determine whether the page is a legal document (privacy, legal notice, terms).
     */
    public function isLegalDocument(): bool
    {
        return $this->component() === 'Legal';
    }

    /**
     * The route name of the page in the given locale, e.g. `en.pricing`.
     */
    public function routeName(Locale $locale): string
    {
        return "{$locale->value}.{$this->value}";
    }

    /**
     * The localized URI of the page, relative to the locale prefix.
     */
    public function uri(Locale $locale): string
    {
        if ($this === self::Home) {
            return '/';
        }

        $uri = __("routes.{$this->value}", locale: $locale->value);

        return is_string($uri) ? $uri : $this->value;
    }

    /**
     * The absolute URL of the page, built on the configured application URL.
     */
    public function url(Locale $locale): string
    {
        return rtrim((string) config('app.url'), '/').route($this->routeName($locale), absolute: false);
    }
}
