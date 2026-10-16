<?php

use Inertia\Testing\AssertableInertia as Assert;

it('serves each page at its localized URL', function (string $path, string $component, string $locale) {
    $response = $this->get($path);

    $response->assertOk()
        ->assertInertia(fn (Assert $page) => $page
            ->component($component)
            ->where('locale', $locale)
            ->etc());
})->with([
    'fr home' => ['/', 'Home', 'fr'],
    'fr services' => ['/services', 'Services', 'fr'],
    'fr pricing' => ['/tarifs', 'Pricing', 'fr'],
    'fr how it works' => ['/comment-ca-marche', 'HowItWorks', 'fr'],
    'fr about' => ['/a-propos', 'About', 'fr'],
    'fr contact' => ['/contact', 'Contact', 'fr'],
    'fr privacy policy' => ['/politique-de-confidentialite', 'Legal', 'fr'],
    'fr legal notice' => ['/mentions-legales', 'Legal', 'fr'],
    'fr terms' => ['/conditions-generales', 'Legal', 'fr'],
    'en home' => ['/en', 'Home', 'en'],
    'en services' => ['/en/services', 'Services', 'en'],
    'en pricing' => ['/en/pricing', 'Pricing', 'en'],
    'en how it works' => ['/en/how-it-works', 'HowItWorks', 'en'],
    'en about' => ['/en/about', 'About', 'en'],
    'en contact' => ['/en/contact', 'Contact', 'en'],
    'en privacy policy' => ['/en/privacy-policy', 'Legal', 'en'],
    'en legal notice' => ['/en/legal-notice', 'Legal', 'en'],
    'en terms' => ['/en/terms-and-conditions', 'Legal', 'en'],
]);

it('sets the document language from the URL', function (string $path, string $language) {
    $response = $this->get($path);

    $response->assertOk()->assertSee("<html lang=\"{$language}\">", false);
})->with([
    'French by default' => ['/', 'fr'],
    'English under /en' => ['/en/pricing', 'en'],
]);

it('shares the translations of the current language', function (string $path, string $homeLabel) {
    $response = $this->get($path);

    $response->assertInertia(fn (Assert $page) => $page
        ->where('translations.nav.home', $homeLabel)
        ->where('translations.common.cta.quote', $path === '/' ? 'Demander un devis' : 'Request a Quote')
        ->etc());
})->with([
    'French' => ['/', 'Accueil'],
    'English' => ['/en', 'Home'],
]);

it('provides canonical and hreflang metadata for every language', function () {
    $response = $this->get('/en/pricing');

    $response->assertInertia(fn (Assert $page) => $page
        ->where('seo.title', 'Cleaning prices | Brillance Plus')
        ->where('seo.canonical', 'https://brillance-plus.fr/en/pricing')
        ->where('seo.alternates', [
            'fr' => 'https://brillance-plus.fr/tarifs',
            'en' => 'https://brillance-plus.fr/en/pricing',
        ])
        ->where('seo.defaultAlternate', 'https://brillance-plus.fr/tarifs')
        ->where('seo.paths', ['fr' => '/tarifs', 'en' => '/en/pricing'])
        ->where('seo.openGraphLocale', 'en_GB')
        ->etc());
});

it('renders the metadata in the HTML head without server-side rendering', function () {
    $response = $this->get('/tarifs');

    $response->assertOk()
        ->assertSee('<title>Nos tarifs de ménage | Brillance Plus</title>', false)
        ->assertSee('<link data-inertia="canonical" rel="canonical" href="https://brillance-plus.fr/tarifs">', false)
        ->assertSee('<link data-inertia="alternate-en" rel="alternate" hreflang="en" href="https://brillance-plus.fr/en/pricing">', false)
        ->assertSee('<link data-inertia="alternate-x-default" rel="alternate" hreflang="x-default" href="https://brillance-plus.fr/tarifs">', false)
        ->assertSee('<meta data-inertia="og:locale" property="og:locale" content="fr_FR">', false);
});

it('describes the starting prices in the page metadata', function (string $path, string $apartmentPrice, string $housePrice) {
    $response = $this->get($path);

    $description = $response->inertiaProps('seo.description');

    expect($description)
        ->toContain($apartmentPrice)
        ->toContain($housePrice);
})->with([
    'French' => ['/', "30\u{00A0}€/heure", "50\u{00A0}€/heure"],
    'English' => ['/en', '€30/hour', '€50/hour'],
]);

it('shares the business contact details and starting prices', function () {
    $response = $this->get('/');

    $response->assertInertia(fn (Assert $page) => $page
        ->where('business.phone', '+330780647327')
        ->where('business.phoneDisplay', '07 80 64 73 27')
        ->where('business.email', null)
        ->where('business.whatsappUrl', 'https://wa.me/33780647327?text=Bonjour%20Brillance%20Plus%2C%20je%20souhaite%20des%20informations%20sur%20vos%20prestations%20de%20m%C3%A9nage.')
        ->where('business.messengerUrl', null)
        ->where('business.currency', 'EUR')
        ->where('business.hourlyPricesFrom', ['apartment' => 30, 'house' => 50])
        ->etc());
});

it('shares the optional contact channels once they are configured', function () {
    config([
        'business.email' => 'contact@brillance-plus.fr',
        'business.messenger' => '@brillanceplus',
        'business.whatsapp' => '',
    ]);

    $response = $this->get('/');

    $response->assertInertia(fn (Assert $page) => $page
        ->where('business.email', 'contact@brillance-plus.fr')
        ->where('business.messengerUrl', 'https://m.me/brillanceplus')
        ->where('business.whatsappUrl', null)
        ->etc());
});

it('builds the Messenger link from a Facebook address or username', function (string $configured, ?string $expected) {
    config(['business.messenger' => $configured]);

    $response = $this->get('/');

    $response->assertInertia(fn (Assert $page) => $page
        ->where('business.messengerUrl', $expected)
        ->etc());
})->with([
    'profile address' => ['https://www.facebook.com/profile.php?id=100009254291388', 'https://m.me/100009254291388'],
    'page address' => ['https://www.facebook.com/brillanceplus/', 'https://m.me/brillanceplus'],
    'm.me link' => ['https://m.me/brillanceplus', 'https://m.me/brillanceplus'],
    'private conversation address' => ['https://www.facebook.com/messages/e2ee/t/24922483680733530', null],
    'another website' => ['https://example.com/brillanceplus', null],
]);

it('publishes only verified business facts as structured data', function () {
    $response = $this->get('/');

    $response->assertOk()
        ->assertSee('<script type="application/ld+json">', false)
        ->assertSee('"@type":"LocalBusiness"', false)
        ->assertSee('"telephone":"+330780647327"', false)
        ->assertSee('"minPrice":30', false)
        ->assertSee('"minPrice":50', false)
        ->assertSee('"creator":{"@type":"Organization","name":"WebSavvys","url":"https://websavvys.com/"', false)
        ->assertDontSee('"address"', false)
        ->assertDontSee('"aggregateRating"', false)
        ->assertDontSee('"openingHours"', false);
});

it('pre-selects the service and package requested from a call to action', function () {
    $response = $this->get('/contact?service=house&package=comfort');

    $response->assertInertia(fn (Assert $page) => $page
        ->component('Contact')
        ->where('prefill', [
            'service' => 'house',
            'package' => 'comfort',
            'property_type' => 'house',
        ])
        ->has('formToken')
        ->has('options.services', 6)
        ->has('options.packages', 3)
        ->has('options.frequencies', 4)
        ->etc());
});

it('ignores unknown pre-selected values', function () {
    $response = $this->get('/contact?service=pool&package=gold&property_type=castle');

    $response->assertInertia(fn (Assert $page) => $page
        ->where('prefill', [
            'service' => null,
            'package' => null,
            'property_type' => null,
        ])
        ->etc());
});

it('marks legal details that have not been configured as to be completed', function () {
    $response = $this->get('/mentions-legales');

    $response->assertInertia(fn (Assert $page) => $page
        ->component('Legal')
        ->where('document.title', 'Mentions légales')
        ->where('document.sections.0.list.1', 'Dénomination sociale : [à compléter]')
        ->where('document.sections.0.list.6', 'Téléphone : 07 80 64 73 27')
        ->etc());
});

it('shows the configured legal details', function () {
    config(['business.legal.company_name' => 'Brillance Plus SAS']);

    $response = $this->get('/en/legal-notice');

    $response->assertInertia(fn (Assert $page) => $page
        ->where('document.sections.0.list.1', 'Company name: Brillance Plus SAS')
        ->etc());
});
