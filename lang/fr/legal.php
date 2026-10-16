<?php

return [
    'eyebrow' => 'Informations légales',
    'updated_at' => 'Dernière mise à jour : :date',
    'to_complete' => '[à compléter]',
    'related' => 'Voir aussi',
    'contact_phone' => 'par téléphone au :phone',
    'contact_phone_and_email' => 'par téléphone au :phone ou par e-mail à :email',

    'privacy_policy' => [
        'title' => 'Politique de confidentialité',
        'intro' => 'Cette politique explique quelles données personnelles nous collectons via le site :site, pourquoi nous les utilisons et comment vous pouvez exercer vos droits.',
        'sections' => [
            [
                'heading' => 'Responsable du traitement',
                'paragraphs' => [
                    'Le responsable du traitement des données collectées sur ce site est :company_name, :address.',
                    'Pour toute question relative à vos données, vous pouvez nous contacter :contact.',
                ],
            ],
            [
                'heading' => 'Données collectées',
                'paragraphs' => [
                    'Lorsque vous envoyez une demande de devis, nous collectons uniquement les informations nécessaires à son traitement :',
                ],
                'list' => [
                    'vos coordonnées : nom, adresse e-mail, numéro de téléphone et langue de contact ;',
                    'les caractéristiques de votre logement : type, surface approximative et nombre de pièces ;',
                    'votre besoin : prestation, formule, fréquence, date et créneau souhaités, ainsi que les précisions que vous choisissez d’ajouter.',
                ],
                'after' => [
                    'Nous vous invitons à ne pas communiquer de données sensibles (santé, opinions, etc.) dans le champ « Précisions ».',
                ],
            ],
            [
                'heading' => 'Finalités et base légale',
                'paragraphs' => [
                    'Vos données sont utilisées pour étudier votre demande, vous recontacter et, le cas échéant, organiser la prestation convenue avec vous.',
                    'Ce traitement repose sur l’exécution de mesures précontractuelles prises à votre demande (article 6.1.b du Règlement général sur la protection des données). Vos données ne sont pas utilisées à des fins de prospection commerciale.',
                ],
            ],
            [
                'heading' => 'Destinataires',
                'paragraphs' => [
                    'Vos données sont destinées exclusivement à Brillance Plus. Elles peuvent être techniquement traitées par nos prestataires d’hébergement et d’envoi d’e-mails, uniquement pour les besoins du service. Elles ne sont ni vendues ni cédées à des tiers.',
                ],
            ],
            [
                'heading' => 'Durée de conservation',
                'paragraphs' => [
                    'Les demandes de devis sont conservées pendant :retention_years ans à compter de leur réception, puis supprimées automatiquement.',
                ],
            ],
            [
                'heading' => 'Vos droits',
                'paragraphs' => [
                    'Conformément à la réglementation applicable, vous disposez d’un droit d’accès, de rectification, d’effacement, de limitation, d’opposition et de portabilité de vos données.',
                    'Pour exercer ces droits, contactez-nous :contact. Si vous estimez, après nous avoir contactés, que vos droits ne sont pas respectés, vous pouvez adresser une réclamation à la CNIL (www.cnil.fr).',
                ],
            ],
            [
                'heading' => 'Cookies et stockage local',
                'paragraphs' => [
                    'Ce site n’utilise ni cookies publicitaires ni outils de mesure d’audience. Il dépose uniquement les cookies strictement nécessaires à son fonctionnement et à sa sécurité (session et protection des formulaires).',
                    'Votre préférence d’affichage (thème clair, sombre ou système) est enregistrée dans le stockage local de votre navigateur. Elle reste sur votre appareil et ne nous est pas transmise.',
                ],
            ],
            [
                'heading' => 'Sécurité',
                'paragraphs' => [
                    'Nous mettons en œuvre des mesures techniques et organisationnelles adaptées pour protéger vos données, notamment en limitant leur accès et en protégeant le formulaire contre les envois automatisés.',
                ],
            ],
        ],
    ],

    'legal_notice' => [
        'title' => 'Mentions légales',
        'intro' => 'Informations relatives à l’éditeur et à l’hébergeur du site :site.',
        'sections' => [
            [
                'heading' => 'Éditeur du site',
                'list' => [
                    'Nom commercial : Brillance Plus',
                    'Dénomination sociale : :company_name',
                    'Forme juridique : :legal_form',
                    'Adresse : :address',
                    'Immatriculation : :registration_number',
                    'Numéro de TVA intracommunautaire : :vat_number',
                    'Téléphone : :phone',
                    'E-mail : :email',
                ],
            ],
            [
                'heading' => 'Directeur de la publication',
                'paragraphs' => [
                    ':publication_director',
                ],
            ],
            [
                'heading' => 'Hébergement',
                'paragraphs' => [
                    ':host',
                ],
            ],
            [
                'heading' => 'Conception et réalisation',
                'paragraphs' => [
                    'Site conçu et développé par WebSavvys (websavvys.com).',
                ],
            ],
            [
                'heading' => 'Propriété intellectuelle',
                'paragraphs' => [
                    'Les textes, le nom et le logo Brillance Plus ainsi que la présentation du site sont protégés. Toute reproduction sans autorisation préalable est interdite.',
                    'Certaines photographies proviennent de la plateforme Unsplash et sont utilisées conformément à la licence Unsplash.',
                ],
            ],
            [
                'heading' => 'Informations présentées',
                'paragraphs' => [
                    'Les tarifs affichés sur ce site sont des prix de départ. Ils ne constituent pas un devis : le tarif final est confirmé avec chaque client avant la prestation.',
                ],
            ],
            [
                'heading' => 'Données personnelles',
                'paragraphs' => [
                    'Le traitement des données transmises via le site est décrit dans notre politique de confidentialité.',
                ],
            ],
        ],
    ],

    'terms' => [
        'title' => 'Conditions générales',
        'intro' => 'Les présentes conditions générales encadrent les prestations de ménage proposées par Brillance Plus à ses clients particuliers.',
        'sections' => [
            [
                'heading' => 'Demande de devis',
                'paragraphs' => [
                    'Vous pouvez nous présenter votre besoin via le formulaire du site ou par téléphone. Une demande de devis est gratuite et sans engagement : elle ne constitue pas une réservation.',
                ],
            ],
            [
                'heading' => 'Confirmation de la prestation',
                'paragraphs' => [
                    'Après échange avec vous, nous convenons du contenu de la prestation, du tarif horaire applicable, de la durée estimée et de la date d’intervention. La prestation n’est réservée qu’une fois ces éléments confirmés.',
                ],
            ],
            [
                'heading' => 'Tarifs',
                'paragraphs' => [
                    'Nos prestations sont facturées à l’heure. Les prix affichés sur le site sont des prix de départ : ménage d’appartement à partir de :apartment/heure, ménage de maison à partir de :house/heure.',
                    'Le tarif applicable, ainsi que tout éventuel élément de prix complémentaire, vous est communiqué avant la confirmation de la prestation.',
                ],
            ],
            [
                'heading' => 'Paiement',
                'paragraphs' => [
                    'Le paiement s’effectue sur place, après la réalisation de la prestation. Aucun paiement n’est demandé en ligne. Les moyens de paiement acceptés vous sont précisés lors de la confirmation.',
                ],
            ],
            [
                'heading' => 'Modification et annulation',
                'paragraphs' => [
                    'Toute demande de modification ou d’annulation doit nous être signalée dès que possible. Les conditions applicables vous sont précisées lors de la confirmation de la prestation.',
                    'Lorsque le contrat est conclu à distance ou hors établissement, vous bénéficiez du droit de rétractation prévu par le Code de la consommation, dans les conditions qu’il fixe. Ses modalités d’exercice vous sont communiquées lors de la confirmation.',
                ],
            ],
            [
                'heading' => 'Engagements du client',
                'paragraphs' => [
                    'Pour que la prestation se déroule dans de bonnes conditions, nous vous remercions :',
                ],
                'list' => [
                    'de nous permettre l’accès au logement à la date et à l’heure convenues ;',
                    'de nous transmettre des informations exactes sur le logement et vos attentes ;',
                    'de nous signaler les objets fragiles, les surfaces délicates et les consignes particulières.',
                ],
            ],
            [
                'heading' => 'Réclamations et médiation',
                'paragraphs' => [
                    'Pour toute réclamation, contactez-nous :contact. Nous étudierons votre demande avec attention.',
                    'Conformément au Code de la consommation, vous pouvez recourir gratuitement au médiateur de la consommation suivant : :mediator.',
                ],
            ],
            [
                'heading' => 'Droit applicable',
                'paragraphs' => [
                    'Les présentes conditions sont soumises au droit français.',
                ],
            ],
        ],
    ],
];
