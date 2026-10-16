<?php

namespace App\Enums;

use App\Enums\Concerns\HasTranslatedLabel;

enum PropertyType: string
{
    use HasTranslatedLabel;

    case Apartment = 'apartment';
    case House = 'house';

    public static function translationGroup(): string
    {
        return 'property_type';
    }
}
