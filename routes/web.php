<?php

use App\Enums\Locale;
use App\Enums\SitePage;
use App\Http\Controllers\InquiryController;
use App\Http\Controllers\PageController;
use App\Http\Controllers\SitemapController;
use Illuminate\Support\Facades\Route;

foreach (Locale::cases() as $locale) {
    Route::prefix($locale->routePrefix())
        ->name("{$locale->value}.")
        ->group(function () use ($locale): void {
            foreach (SitePage::cases() as $page) {
                Route::get($page->uri($locale), PageController::class)
                    ->name($page->value)
                    ->defaults('page', $page->value);
            }

            Route::post(SitePage::Contact->uri($locale), [InquiryController::class, 'store'])
                ->name('inquiries.store')
                ->middleware('throttle:inquiries');
        });
}

Route::get('sitemap.xml', SitemapController::class)->name('sitemap');
