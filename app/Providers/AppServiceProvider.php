<?php

namespace App\Providers;

use Carbon\CarbonImmutable;
use Illuminate\Cache\RateLimiting\Limit;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Date;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\ServiceProvider;
use Illuminate\Validation\Rules\Password;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        $this->configureDefaults();
        $this->configureRateLimiting();
    }

    /**
     * Configure default behaviors for production-ready applications.
     */
    protected function configureDefaults(): void
    {
        Date::use(CarbonImmutable::class);

        DB::prohibitDestructiveCommands(
            app()->isProduction(),
        );

        Password::defaults(fn (): ?Password => app()->isProduction()
            ? Password::min(12)
                ->mixedCase()
                ->letters()
                ->numbers()
                ->symbols()
                ->uncompromised()
            : null,
        );
    }

    /**
     * Limit quote requests per visitor, answering with a form error instead of a bare 429 page.
     */
    protected function configureRateLimiting(): void
    {
        RateLimiter::for('inquiries', function (Request $request): array {
            $tooManyAttempts = fn (): RedirectResponse => back()->withErrors([
                'form' => __('contact.errors.too_many_attempts', ['phone' => config('business.phone_display')]),
            ]);

            return [
                Limit::perMinute(8)->by('minute:'.$request->ip())->response($tooManyAttempts),
                Limit::perDay(30)->by('day:'.$request->ip())->response($tooManyAttempts),
            ];
        });
    }
}
