<?php

namespace App\Enums\Concerns;

trait HasTranslatedLabel
{
    /**
     * The key of the group holding this enum's labels in `lang/{locale}/enums.php`.
     */
    abstract public static function translationGroup(): string;

    /**
     * Get the human-readable label of the case in the given (or current) locale.
     */
    public function label(?string $locale = null): string
    {
        $label = __('enums.'.static::translationGroup().'.'.$this->value, locale: $locale);

        return is_string($label) ? $label : $this->value;
    }

    /**
     * Get every case as a value / label pair, in declaration order.
     *
     * @return list<array{value: string, label: string}>
     */
    public static function options(): array
    {
        return array_map(
            fn (self $case): array => ['value' => $case->value, 'label' => $case->label()],
            self::cases(),
        );
    }
}
