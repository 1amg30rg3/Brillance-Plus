<?php

namespace App\Enums;

use App\Enums\Concerns\HasTranslatedLabel;

enum ServicePackage: string
{
    use HasTranslatedLabel;

    case Essential = 'essential';
    case Comfort = 'comfort';
    case Premium = 'premium';

    public static function translationGroup(): string
    {
        return 'service_package';
    }
}
