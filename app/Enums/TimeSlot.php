<?php

namespace App\Enums;

use App\Enums\Concerns\HasTranslatedLabel;

enum TimeSlot: string
{
    use HasTranslatedLabel;

    case Morning = 'morning';
    case Afternoon = 'afternoon';
    case Evening = 'evening';

    public static function translationGroup(): string
    {
        return 'time_slot';
    }
}
