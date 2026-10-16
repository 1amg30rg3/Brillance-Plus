<?php

namespace App\Http\Middleware;

use App\Enums\Locale;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Str;
use Symfony\Component\HttpFoundation\Response;

class SetLocale
{
    /**
     * Run the request in the locale encoded in its route name (`fr.*`, `en.*`).
     *
     * Routes without a locale prefix, such as the sitemap, use the default locale.
     *
     * @param  Closure(Request): (Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $routeName = (string) $request->route()?->getName();

        App::setLocale((Locale::tryFrom(Str::before($routeName, '.')) ?? Locale::default())->value);

        return $next($request);
    }
}
