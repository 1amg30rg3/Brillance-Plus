<?php

namespace App\Models;

use App\Enums\CleaningFrequency;
use App\Enums\CleaningService;
use App\Enums\Locale;
use App\Enums\PropertyType;
use App\Enums\ServicePackage;
use App\Enums\TimeSlot;
use Carbon\CarbonImmutable;
use Database\Factories\InquiryFactory;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Prunable;

/**
 * A quote request submitted through the website's contact form.
 *
 * @property int $id
 * @property string $name
 * @property string $email
 * @property string $phone
 * @property Locale $preferred_language
 * @property PropertyType $property_type
 * @property CleaningService $service
 * @property ServicePackage|null $package
 * @property CarbonImmutable|null $preferred_date
 * @property TimeSlot|null $preferred_time_slot
 * @property int|null $property_size
 * @property int|null $rooms
 * @property CleaningFrequency $frequency
 * @property string|null $message
 * @property CarbonImmutable $privacy_consented_at
 * @property CarbonImmutable $created_at
 * @property CarbonImmutable $updated_at
 */
class Inquiry extends Model
{
    /** @use HasFactory<InquiryFactory> */
    use HasFactory;

    use Prunable;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'email',
        'phone',
        'preferred_language',
        'property_type',
        'service',
        'package',
        'preferred_date',
        'preferred_time_slot',
        'property_size',
        'rooms',
        'frequency',
        'message',
        'privacy_consented_at',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'preferred_language' => Locale::class,
            'property_type' => PropertyType::class,
            'service' => CleaningService::class,
            'package' => ServicePackage::class,
            'preferred_date' => 'date',
            'preferred_time_slot' => TimeSlot::class,
            'property_size' => 'integer',
            'rooms' => 'integer',
            'frequency' => CleaningFrequency::class,
            'privacy_consented_at' => 'datetime',
        ];
    }

    /**
     * Inquiries are personal data: delete them once the retention period has elapsed.
     *
     * @return Builder<static>
     */
    public function prunable(): Builder
    {
        return static::query()->where(
            'created_at',
            '<',
            now()->subYears((int) config('business.inquiries.retention_years')),
        );
    }
}
