<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Business Identity
    |--------------------------------------------------------------------------
    |
    | Public contact details displayed on the website. The phone number is
    | used verbatim in "tel:" links, while the display value is what visitors
    | read. The email address is optional: when it is empty, the website does
    | not render any "mailto:" link or email address.
    |
    */

    'name' => 'Brillance Plus',

    'phone' => env('BUSINESS_PHONE', '+330780647327'),

    'phone_display' => env('BUSINESS_PHONE_DISPLAY', '07 80 64 73 27'),

    'email' => env('BUSINESS_EMAIL'),

    /*
    |--------------------------------------------------------------------------
    | Messaging
    |--------------------------------------------------------------------------
    |
    | WhatsApp: the number in international format (it defaults to the
    | business mobile). Messenger: a Facebook page or profile address
    | (facebook.com/name or facebook.com/profile.php?id=...), an m.me link
    | or a username. A channel left empty is not displayed on the website.
    |
    */

    'whatsapp' => env('BUSINESS_WHATSAPP', '+33 7 80 64 73 27'),

    'messenger' => env('BUSINESS_MESSENGER'),

    /*
    |--------------------------------------------------------------------------
    | Pricing
    |--------------------------------------------------------------------------
    |
    | Hourly starting prices (in euros), keyed by cleaning service. Only the
    | services listed here display a price; every other service is offered
    | on quotation. Final rates are always confirmed with the customer.
    |
    */

    'pricing' => [
        'currency' => 'EUR',

        'hourly_from' => [
            'apartment' => 30,
            'house' => 50,
        ],
    ],

    /*
    |--------------------------------------------------------------------------
    | Quote Requests
    |--------------------------------------------------------------------------
    |
    | The notification email receives every quote request submitted on the
    | website (it defaults to the public business email). Customer
    | confirmation emails are opt-in: enable them only once a real mail
    | transport (SMTP, Postmark, SES...) has been configured and tested.
    |
    */

    'inquiries' => [
        'notification_email' => env('INQUIRY_NOTIFICATION_EMAIL', env('BUSINESS_EMAIL')),

        'send_customer_confirmation' => (bool) env('INQUIRY_SEND_CUSTOMER_CONFIRMATION', false),

        'minimum_fill_seconds' => 3,

        'retention_years' => 3,
    ],

    /*
    |--------------------------------------------------------------------------
    | Legal Information
    |--------------------------------------------------------------------------
    |
    | Details required by French law on the "Mentions légales" page. Leave a
    | value empty until it is known: the website then shows it as "to be
    | completed" rather than displaying invented information.
    |
    */

    'legal' => [
        'company_name' => env('LEGAL_COMPANY_NAME'),
        'legal_form' => env('LEGAL_FORM'),
        'address' => env('LEGAL_ADDRESS'),
        'registration_number' => env('LEGAL_REGISTRATION_NUMBER'),
        'vat_number' => env('LEGAL_VAT_NUMBER'),
        'publication_director' => env('LEGAL_PUBLICATION_DIRECTOR'),
        'host' => env('LEGAL_HOST'),
        'consumer_mediator' => env('LEGAL_CONSUMER_MEDIATOR'),
        'documents_updated_at' => '2026-10-16',
    ],

];
