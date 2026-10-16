<?php

namespace App\Enums;

use App\Enums\Concerns\HasTranslatedLabel;

enum CleaningService: string
{
    use HasTranslatedLabel;

    case Apartment = 'apartment';
    case House = 'house';
    case KitchenBathroom = 'kitchen_bathroom';
    case Regular = 'regular';
    case Deep = 'deep';
    case MoveInOut = 'move_in_out';

    public static function translationGroup(): string
    {
        return 'cleaning_service';
    }

    /**
     * The configured hourly starting price in euros, or null when the service is quoted individually.
     */
    public function hourlyPriceFrom(): ?int
    {
        $price = config("business.pricing.hourly_from.{$this->value}");

        return is_numeric($price) ? (int) $price : null;
    }
}
