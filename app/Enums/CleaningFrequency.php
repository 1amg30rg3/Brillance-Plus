<?php

namespace App\Enums;

use App\Enums\Concerns\HasTranslatedLabel;

enum CleaningFrequency: string
{
    use HasTranslatedLabel;

    case OneTime = 'one_time';
    case Weekly = 'weekly';
    case EveryTwoWeeks = 'every_two_weeks';
    case Monthly = 'monthly';

    public static function translationGroup(): string
    {
        return 'cleaning_frequency';
    }
}
