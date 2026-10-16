<?php

namespace App\Enums;

enum Locale: string
{
    case French = 'fr';
    case English = 'en';

    /**
     * The locale served without a URL prefix.
     */
    public static function default(): self
    {
        return self::French;
    }

    /**
     * Resolve the locale the application is currently running in.
     */
    public static function current(): self
    {
        return self::tryFrom(app()->getLocale()) ?? self::default();
    }

    /**
     * The URL prefix of this locale's routes (empty for the default locale).
     */
    public function routePrefix(): string
    {
        return $this === self::default() ? '' : $this->value;
    }

    /**
     * The locale identifier used by Open Graph metadata.
     */
    public function openGraphLocale(): string
    {
        return match ($this) {
            self::French => 'fr_FR',
            self::English => 'en_GB',
        };
    }

    /**
     * The name of the language, written in that language.
     */
    public function nativeName(): string
    {
        return match ($this) {
            self::French => 'Français',
            self::English => 'English',
        };
    }

    /**
     * Format a whole euro amount the way it is written in this language.
     *
     * Kept dependency-free so it works without the PHP intl extension.
     */
    public function formatEuros(int $amount): string
    {
        return match ($this) {
            self::French => "{$amount}\u{00A0}€",
            self::English => "€{$amount}",
        };
    }
}
