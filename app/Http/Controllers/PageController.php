<?php

namespace App\Http\Controllers;

use App\Enums\CleaningFrequency;
use App\Enums\CleaningService;
use App\Enums\Locale;
use App\Enums\PropertyType;
use App\Enums\ServicePackage;
use App\Enums\SitePage;
use App\Enums\TimeSlot;
use App\Support\LegalDocument;
use App\Support\PageMetadata;
use App\Support\StructuredData;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Crypt;
use Inertia\Inertia;
use Inertia\Response;

class PageController extends Controller
{
    /**
     * Render a localized page of the website.
     */
    public function __invoke(
        Request $request,
        SitePage $page,
        PageMetadata $metadata,
        LegalDocument $legalDocument,
        StructuredData $structuredData,
    ): Response {
        $locale = Locale::current();

        $props = ['seo' => $metadata->for($page, $locale)];

        if ($page === SitePage::Contact) {
            $props = [...$props, ...$this->contactProps($request)];
        }

        if ($page->isLegalDocument()) {
            $props['document'] = $legalDocument->for($page, $locale);
        }

        return Inertia::render($page->component(), $props)
            ->withViewData(['structuredData' => $structuredData->for($locale)]);
    }

    /**
     * The quote request form's choices, pre-selected values and anti-spam token.
     *
     * @return array{
     *     options: array<string, list<array{value: string, label: string}>>,
     *     prefill: array{service: ?string, package: ?string, property_type: ?string},
     *     formToken: string,
     * }
     */
    private function contactProps(Request $request): array
    {
        $service = CleaningService::tryFrom($request->string('service')->toString());

        $propertyType = PropertyType::tryFrom($request->string('property_type')->toString())
            ?? match ($service) {
                CleaningService::Apartment => PropertyType::Apartment,
                CleaningService::House => PropertyType::House,
                default => null,
            };

        return [
            'options' => [
                'languages' => array_map(
                    fn (Locale $locale): array => ['value' => $locale->value, 'label' => $locale->nativeName()],
                    Locale::cases(),
                ),
                'propertyTypes' => PropertyType::options(),
                'services' => CleaningService::options(),
                'packages' => ServicePackage::options(),
                'frequencies' => CleaningFrequency::options(),
                'timeSlots' => TimeSlot::options(),
            ],
            'prefill' => [
                'service' => $service?->value,
                'package' => ServicePackage::tryFrom($request->string('package')->toString())?->value,
                'property_type' => $propertyType?->value,
            ],
            'formToken' => Crypt::encryptString((string) now()->getTimestamp()),
        ];
    }
}
