<?php

namespace App\Http\Controllers;

use App\Enums\Locale;
use App\Enums\SitePage;
use Illuminate\Http\Response;

class SitemapController extends Controller
{
    /**
     * List every localized page, with its language alternates, for search engines.
     */
    public function __invoke(): Response
    {
        $entries = [];

        foreach (SitePage::cases() as $page) {
            foreach (Locale::cases() as $locale) {
                $entries[] = [
                    'url' => $page->url($locale),
                    'alternates' => array_map(
                        fn (Locale $alternate): array => ['hreflang' => $alternate->value, 'url' => $page->url($alternate)],
                        Locale::cases(),
                    ),
                    'defaultAlternate' => $page->url(Locale::default()),
                ];
            }
        }

        return response()
            ->view('sitemap', ['entries' => $entries])
            ->header('Content-Type', 'application/xml; charset=UTF-8');
    }
}
