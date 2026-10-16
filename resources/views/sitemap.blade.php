{!! '<'.'?xml version="1.0" encoding="UTF-8"?>' !!}
<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9" xmlns:xhtml="http://www.w3.org/1999/xhtml">
@foreach ($entries as $entry)
    <url>
        <loc>{{ $entry['url'] }}</loc>
@foreach ($entry['alternates'] as $alternate)
        <xhtml:link rel="alternate" hreflang="{{ $alternate['hreflang'] }}" href="{{ $alternate['url'] }}" />
@endforeach
        <xhtml:link rel="alternate" hreflang="x-default" href="{{ $entry['defaultAlternate'] }}" />
    </url>
@endforeach
</urlset>
