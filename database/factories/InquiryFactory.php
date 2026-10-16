<?php

namespace Database\Factories;

use App\Enums\CleaningFrequency;
use App\Enums\CleaningService;
use App\Enums\Locale;
use App\Enums\PropertyType;
use App\Enums\ServicePackage;
use App\Enums\TimeSlot;
use App\Models\Inquiry;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Inquiry>
 */
class InquiryFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'name' => fake()->name(),
            'email' => fake()->safeEmail(),
            'phone' => '06 12 34 56 78',
            'preferred_language' => Locale::French,
            'property_type' => PropertyType::Apartment,
            'service' => CleaningService::Apartment,
            'package' => null,
            'preferred_date' => null,
            'preferred_time_slot' => null,
            'property_size' => null,
            'rooms' => null,
            'frequency' => CleaningFrequency::OneTime,
            'message' => null,
            'privacy_consented_at' => now(),
        ];
    }

    /**
     * An inquiry with every optional detail filled in.
     */
    public function detailed(): static
    {
        return $this->state(fn (): array => [
            'property_type' => PropertyType::House,
            'service' => CleaningService::Deep,
            'package' => ServicePackage::Comfort,
            'preferred_date' => now()->addWeek()->startOfDay(),
            'preferred_time_slot' => TimeSlot::Morning,
            'property_size' => 120,
            'rooms' => 5,
            'frequency' => CleaningFrequency::EveryTwoWeeks,
            'message' => fake()->paragraph(),
        ]);
    }

    /**
     * An inquiry from a visitor who prefers to be contacted in English.
     */
    public function inEnglish(): static
    {
        return $this->state(fn (): array => [
            'preferred_language' => Locale::English,
        ]);
    }
}
