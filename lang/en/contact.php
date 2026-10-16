<?php

return [
    'page' => [
        'eyebrow' => 'Contact and quotes',
        'title' => 'Request your cleaning quote',
        'intro' => 'A few details are all we need to understand what you are looking for. We will then get back to you with a tailored proposal.',
    ],

    'form' => [
        'title' => 'Let’s talk about what you need',
        'subtitle' => 'Fill in the form and we will contact you to discuss your request and offer you a service that suits you.',
        'required_hint' => 'Fields marked with an asterisk (*) are required.',
        'not_a_booking' => 'This form is a quote request: it is not a booking. The service is confirmed after we have talked.',
        'submit' => 'Send my request',
        'submitting' => 'Sending…',
        'select_placeholder' => 'Select an option',
        'no_preference' => 'No preference',
        'undecided_package' => 'Not sure yet',
        'undecided_package_text' => 'We will advise you.',

        'sections' => [
            'contact' => 'Your details',
            'property' => 'Your home',
            'service' => 'Your service',
            'details' => 'Additional details',
        ],

        'fields' => [
            'name' => [
                'label' => 'Full name',
                'placeholder' => 'Jane Smith',
            ],
            'email' => [
                'label' => 'Email address',
                'placeholder' => 'jane.smith@example.com',
            ],
            'phone' => [
                'label' => 'Phone number',
                'placeholder' => '+33 6 12 34 56 78',
            ],
            'preferred_language' => [
                'label' => 'Contact language',
            ],
            'property_type' => [
                'label' => 'Property type',
            ],
            'property_size' => [
                'label' => 'Approximate size',
                'placeholder' => '65',
                'suffix' => 'm²',
            ],
            'rooms' => [
                'label' => 'Number of rooms',
                'placeholder' => '3',
            ],
            'service' => [
                'label' => 'Requested service',
            ],
            'package' => [
                'label' => 'Package',
                'help' => 'Optional: the scope and price are confirmed with you.',
            ],
            'frequency' => [
                'label' => 'Frequency',
            ],
            'preferred_date' => [
                'label' => 'Preferred date',
            ],
            'preferred_time_slot' => [
                'label' => 'Preferred time',
            ],
            'message' => [
                'label' => 'Additional details',
                'placeholder' => 'Access to the property, priority rooms, pets, specific instructions…',
            ],
            'privacy_consent' => [
                'label' => 'I agree that the information I provide will be used to handle my request, in accordance with the :link.',
                'link' => 'privacy policy',
            ],
            'website' => [
                'label' => 'Leave this field empty',
            ],
        ],

        'success' => [
            'title' => 'Thank you for your request!',
            'text' => 'We have received your details and will get back to you shortly.',
            'again' => 'Send another request',
        ],

        'error_summary' => 'Your request could not be sent. Please check the highlighted fields.',
        'new_tab' => '(opens in a new tab)',
        'recommended' => 'Recommended',
    ],

    'errors' => [
        'not_saved' => 'Your request could not be saved. Please try again in a few moments or call us on :phone.',
        'too_many_attempts' => 'Several requests were sent in a short time. Please wait before trying again, or call us on :phone.',
        'spam' => 'Your request could not be sent. Please try again.',
    ],

    'channels' => [
        'title' => 'Prefer a direct conversation?',
        'phone' => [
            'label' => 'By phone',
            'text' => 'Tell us what you need in person.',
        ],
        'whatsapp' => [
            'label' => 'On WhatsApp',
            'text' => 'Send us a message, with photos if helpful.',
        ],
        'messenger' => [
            'label' => 'On Messenger',
            'text' => 'Write to us from Facebook.',
        ],
        'email' => [
            'label' => 'By email',
            'text' => 'Write to us and we will reply.',
        ],
        'payment' => [
            'title' => 'Payment on-site',
            'text' => 'You pay on-site, after the service. No online payment.',
        ],
        'next' => [
            'title' => 'What happens next?',
            'items' => [
                'We review your request.',
                'We contact you to discuss it.',
                'Together we confirm the service, its price and its date.',
            ],
        ],
    ],
];
