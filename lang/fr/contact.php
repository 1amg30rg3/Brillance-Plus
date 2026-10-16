<?php

return [
    'page' => [
        'eyebrow' => 'Contact et devis',
        'title' => 'Demandez votre devis de ménage',
        'intro' => 'Quelques informations suffisent pour comprendre votre besoin. Nous vous recontactons ensuite pour vous proposer une prestation adaptée.',
    ],

    'form' => [
        'title' => 'Parlons de votre besoin',
        'subtitle' => 'Remplissez le formulaire et nous vous contacterons pour discuter de votre demande et vous proposer une prestation adaptée.',
        'required_hint' => 'Les champs marqués d’un astérisque (*) sont obligatoires.',
        'not_a_booking' => 'Ce formulaire est une demande de devis : il ne constitue pas une réservation. La prestation est confirmée après notre échange.',
        'submit' => 'Envoyer ma demande',
        'submitting' => 'Envoi en cours…',
        'select_placeholder' => 'Sélectionnez une option',
        'no_preference' => 'Pas de préférence',
        'undecided_package' => 'Je ne sais pas encore',
        'undecided_package_text' => 'Nous vous conseillerons.',

        'sections' => [
            'contact' => 'Vos coordonnées',
            'property' => 'Votre logement',
            'service' => 'Votre prestation',
            'details' => 'Précisions',
        ],

        'fields' => [
            'name' => [
                'label' => 'Nom complet',
                'placeholder' => 'Marie Dupont',
            ],
            'email' => [
                'label' => 'Adresse e-mail',
                'placeholder' => 'marie.dupont@exemple.fr',
            ],
            'phone' => [
                'label' => 'Téléphone',
                'placeholder' => '06 12 34 56 78',
            ],
            'preferred_language' => [
                'label' => 'Langue de contact',
            ],
            'property_type' => [
                'label' => 'Type de logement',
            ],
            'property_size' => [
                'label' => 'Surface approximative',
                'placeholder' => '65',
                'suffix' => 'm²',
            ],
            'rooms' => [
                'label' => 'Nombre de pièces',
                'placeholder' => '3',
            ],
            'service' => [
                'label' => 'Prestation souhaitée',
            ],
            'package' => [
                'label' => 'Formule',
                'help' => 'Facultatif : le contenu et le prix sont confirmés avec vous.',
            ],
            'frequency' => [
                'label' => 'Fréquence',
            ],
            'preferred_date' => [
                'label' => 'Date souhaitée',
            ],
            'preferred_time_slot' => [
                'label' => 'Créneau souhaité',
            ],
            'message' => [
                'label' => 'Précisions',
                'placeholder' => 'Accès au logement, pièces prioritaires, animaux, consignes particulières…',
            ],
            'privacy_consent' => [
                'label' => 'J’accepte que les informations saisies soient utilisées pour traiter ma demande, conformément à la :link.',
                'link' => 'politique de confidentialité',
            ],
            'website' => [
                'label' => 'Laissez ce champ vide',
            ],
        ],

        'success' => [
            'title' => 'Merci pour votre demande !',
            'text' => 'Nous avons bien reçu vos informations et vous recontacterons prochainement.',
            'again' => 'Envoyer une autre demande',
        ],

        'error_summary' => 'Votre demande n’a pas pu être envoyée. Veuillez vérifier les champs signalés.',
        'new_tab' => '(s’ouvre dans un nouvel onglet)',
        'recommended' => 'Recommandée',
    ],

    'errors' => [
        'not_saved' => 'Votre demande n’a pas pu être enregistrée. Veuillez réessayer dans quelques instants ou nous appeler au :phone.',
        'too_many_attempts' => 'Plusieurs demandes ont été envoyées en peu de temps. Veuillez patienter avant de réessayer, ou appelez-nous au :phone.',
        'spam' => 'Votre demande n’a pas pu être envoyée. Veuillez réessayer.',
    ],

    'channels' => [
        'title' => 'Vous préférez un échange direct ?',
        'phone' => [
            'label' => 'Par téléphone',
            'text' => 'Présentez-nous votre besoin de vive voix.',
        ],
        'whatsapp' => [
            'label' => 'Par WhatsApp',
            'text' => 'Envoyez-nous un message, avec des photos si besoin.',
        ],
        'messenger' => [
            'label' => 'Par Messenger',
            'text' => 'Écrivez-nous depuis Facebook.',
        ],
        'email' => [
            'label' => 'Par e-mail',
            'text' => 'Écrivez-nous, nous vous répondrons.',
        ],
        'payment' => [
            'title' => 'Paiement sur place',
            'text' => 'Vous réglez sur place, après la prestation. Aucun paiement en ligne.',
        ],
        'next' => [
            'title' => 'Et ensuite ?',
            'items' => [
                'Nous étudions votre demande.',
                'Nous vous contactons pour en discuter.',
                'Nous confirmons ensemble la prestation, son tarif et sa date.',
            ],
        ],
    ],
];
