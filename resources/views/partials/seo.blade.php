{{--
    Server-rendered fallback for the page metadata when SSR is not running.
    Each tag carries the same `data-inertia` key as its `head-key` in SeoHead.vue,
    so Inertia's <Head> component takes them over on client-side navigation.
--}}
@if ($seo)
    <title>{{ $seo['title'] }}</title>
    <meta data-inertia="description" name="description" content="{{ $seo['description'] }}">
    <link data-inertia="canonical" rel="canonical" href="{{ $seo['canonical'] }}">
    @foreach ($seo['alternates'] as $hreflang => $url)
        <link data-inertia="alternate-{{ $hreflang }}" rel="alternate" hreflang="{{ $hreflang }}" href="{{ $url }}">
    @endforeach
    <link data-inertia="alternate-x-default" rel="alternate" hreflang="x-default" href="{{ $seo['defaultAlternate'] }}">
    <meta data-inertia="og:type" property="og:type" content="website">
    <meta data-inertia="og:site_name" property="og:site_name" content="{{ $seo['siteName'] }}">
    <meta data-inertia="og:title" property="og:title" content="{{ $seo['title'] }}">
    <meta data-inertia="og:description" property="og:description" content="{{ $seo['description'] }}">
    <meta data-inertia="og:url" property="og:url" content="{{ $seo['canonical'] }}">
    <meta data-inertia="og:image" property="og:image" content="{{ $seo['image'] }}">
    <meta data-inertia="og:image:width" property="og:image:width" content="1200">
    <meta data-inertia="og:image:height" property="og:image:height" content="630">
    <meta data-inertia="og:locale" property="og:locale" content="{{ $seo['openGraphLocale'] }}">
    @foreach ($seo['openGraphAlternateLocales'] as $alternateLocale)
        <meta data-inertia="og:locale:alternate-{{ $alternateLocale }}" property="og:locale:alternate" content="{{ $alternateLocale }}">
    @endforeach
    <meta data-inertia="twitter:card" name="twitter:card" content="summary_large_image">
@else
    <title>{{ config('app.name') }}</title>
@endif
