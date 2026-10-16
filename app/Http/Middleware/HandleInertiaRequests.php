<?php

namespace App\Http\Middleware;

use App\Enums\CleaningService;
use App\Enums\Locale;
use App\Support\MessagingLinks;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Inertia\Middleware;

class HandleInertiaRequests extends Middleware
{
    /**
     * The translation groups made available to the frontend.
     *
     * @var list<string>
     */
    private const array FRONTEND_TRANSLATION_GROUPS = [
        'common',
        'nav',
        'home',
        'services',
        'pricing',
        'packages',
        'process',
        'about',
        'faq',
        'contact',
        'footer',
        'enums',
    ];

    public function __construct(private MessagingLinks $messagingLinks) {}

    /**
     * The root template that's loaded on the first page visit.
     *
     * @see https://inertiajs.com/server-side-setup#root-template
     *
     * @var string
     */
    protected $rootView = 'app';

    /**
     * Determines the current asset version.
     *
     * @see https://inertiajs.com/asset-versioning
     */
    public function version(Request $request): ?string
    {
        return parent::version($request);
    }

    /**
     * Define the props that are shared by default.
     *
     * @see https://inertiajs.com/shared-data
     *
     * @return array<string, mixed>
     */
    public function share(Request $request): array
    {
        $locale = Locale::current();

        return [
            ...parent::share($request),
            'name' => config('app.name'),
            'auth' => [
                'user' => $request->user(),
            ],
            'locale' => $locale->value,
            'translations' => Inertia::once(fn (): array => $this->translations())
                ->as("translations.{$locale->value}"),
            'agency' => [
                'name' => config('agency.name'),
                'url' => config('agency.url'),
            ],
            'business' => [
                'name' => config('business.name'),
                'phone' => config('business.phone'),
                'phoneDisplay' => config('business.phone_display'),
                'email' => filled(config('business.email')) ? config('business.email') : null,
                'whatsappUrl' => $this->messagingLinks->whatsapp((string) __('common.messaging.whatsapp_greeting')),
                'messengerUrl' => $this->messagingLinks->messenger(),
                'currency' => config('business.pricing.currency'),
                'hourlyPricesFrom' => array_filter(array_combine(
                    array_map(fn (CleaningService $service): string => $service->value, CleaningService::cases()),
                    array_map(fn (CleaningService $service): ?int => $service->hourlyPriceFrom(), CleaningService::cases()),
                ), fn (?int $price): bool => $price !== null),
            ],
        ];
    }

    /**
     * The translations of the current locale, keyed by group.
     *
     * @return array<string, mixed>
     */
    private function translations(): array
    {
        $translations = [];

        foreach (self::FRONTEND_TRANSLATION_GROUPS as $group) {
            $translations[$group] = __($group);
        }

        return $translations;
    }
}
