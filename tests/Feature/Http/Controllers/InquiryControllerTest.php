<?php

use App\Enums\CleaningFrequency;
use App\Enums\CleaningService;
use App\Enums\Locale;
use App\Enums\PropertyType;
use App\Enums\ServicePackage;
use App\Enums\TimeSlot;
use App\Mail\InquiryConfirmation;
use App\Mail\InquiryReceived;
use App\Models\Inquiry;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use Symfony\Component\Mailer\Exception\TransportException;
use Symfony\Component\Mailer\SentMessage;
use Symfony\Component\Mailer\Transport\AbstractTransport;

/**
 * A valid quote request, with a form token issued one minute ago.
 *
 * @param  array<string, mixed>  $overrides
 * @return array<string, mixed>
 */
function inquiryPayload(array $overrides = []): array
{
    return [
        'name' => 'Jeanne Martin',
        'email' => 'jeanne.martin@example.com',
        'phone' => '06 12 34 56 78',
        'preferred_language' => 'fr',
        'property_type' => 'apartment',
        'service' => 'apartment',
        'frequency' => 'weekly',
        'privacy_consent' => true,
        'website' => '',
        'form_token' => Crypt::encryptString((string) now()->subMinute()->getTimestamp()),
        ...$overrides,
    ];
}

it('stores the quote request and confirms it to the visitor', function () {
    Mail::fake();

    $response = $this->post(route('fr.inquiries.store'), inquiryPayload([
        'property_type' => 'house',
        'service' => 'deep',
        'package' => 'comfort',
        'property_size' => 120,
        'rooms' => 5,
        'frequency' => 'every_two_weeks',
        'preferred_date' => now()->addWeek()->toDateString(),
        'preferred_time_slot' => 'morning',
        'message' => 'Merci de prévoir les vitres du salon.',
    ]));

    $response->assertRedirect(route('fr.contact'))
        ->assertSessionHasNoErrors()
        ->assertInertiaFlash('inquiry', 'received');

    $inquiry = Inquiry::sole();

    expect($inquiry)
        ->name->toBe('Jeanne Martin')
        ->email->toBe('jeanne.martin@example.com')
        ->phone->toBe('06 12 34 56 78')
        ->preferred_language->toBe(Locale::French)
        ->property_type->toBe(PropertyType::House)
        ->service->toBe(CleaningService::Deep)
        ->package->toBe(ServicePackage::Comfort)
        ->property_size->toBe(120)
        ->rooms->toBe(5)
        ->frequency->toBe(CleaningFrequency::EveryTwoWeeks)
        ->preferred_date->toDateString()->toBe(now()->addWeek()->toDateString())
        ->preferred_time_slot->toBe(TimeSlot::Morning)
        ->message->toBe('Merci de prévoir les vitres du salon.')
        ->privacy_consented_at->not->toBeNull();
});

it('notifies the configured business address of a new request', function () {
    Mail::fake();
    config(['business.inquiries.notification_email' => 'devis@brillance-plus.fr']);

    $this->post(route('fr.inquiries.store'), inquiryPayload());

    Mail::assertSent(InquiryReceived::class, fn (InquiryReceived $mail): bool => $mail->hasTo('devis@brillance-plus.fr')
        && $mail->inquiry->is(Inquiry::sole())
        && $mail->locale === 'fr');
});

it('sends a confirmation in the visitor’s language once confirmations are enabled', function () {
    Mail::fake();
    config(['business.inquiries.send_customer_confirmation' => true]);

    $this->post(route('en.inquiries.store'), inquiryPayload(['preferred_language' => 'en']));

    Mail::assertSent(InquiryConfirmation::class, fn (InquiryConfirmation $mail): bool => $mail->hasTo('jeanne.martin@example.com')
        && $mail->locale === 'en');
});

it('does not email the visitor while customer confirmations are disabled', function () {
    Mail::fake();
    config(['business.inquiries.send_customer_confirmation' => false]);

    $this->post(route('fr.inquiries.store'), inquiryPayload());

    Mail::assertNotSent(InquiryConfirmation::class);
});

it('still accepts the request when no notification address is configured', function () {
    Mail::fake();
    Log::spy();
    config(['business.inquiries.notification_email' => null]);

    $response = $this->post(route('fr.inquiries.store'), inquiryPayload());

    $response->assertInertiaFlash('inquiry', 'received');
    $this->assertDatabaseCount('inquiries', 1);
    Mail::assertNothingSent();
    Log::shouldHaveReceived('warning')->once()->withArgs(
        fn (string $message, array $context): bool => str_contains($message, 'no notification email address')
            && $context === ['inquiry_id' => Inquiry::sole()->id],
    );
});

it('keeps the saved request and logs no personal data when the email cannot be sent', function () {
    Log::spy();
    Mail::extend('failing', fn () => new class extends AbstractTransport
    {
        protected function doSend(SentMessage $message): void
        {
            throw new TransportException('550 Mailbox jeanne.martin@example.com unavailable');
        }

        public function __toString(): string
        {
            return 'failing://';
        }
    });
    config([
        'mail.mailers.failing' => ['transport' => 'failing'],
        'mail.default' => 'failing',
        'business.inquiries.notification_email' => 'devis@brillance-plus.fr',
    ]);

    $response = $this->post(route('fr.inquiries.store'), inquiryPayload());

    $response->assertRedirect(route('fr.contact'))->assertInertiaFlash('inquiry', 'received');
    $this->assertDatabaseCount('inquiries', 1);
    Log::shouldHaveReceived('error')->once()->withArgs(
        fn (string $message, array $context): bool => $message === 'A quote request email could not be sent.'
            && $context === [
                'inquiry_id' => Inquiry::sole()->id,
                'mailable' => InquiryReceived::class,
                'exception' => TransportException::class,
            ],
    );
});

it('does not report success when the request cannot be saved', function () {
    Mail::fake();
    Log::spy();
    Inquiry::creating(fn () => throw new RuntimeException('SQLSTATE[HY000]: insert into inquiries (jeanne.martin@example.com)'));

    $response = $this->post(route('fr.inquiries.store'), inquiryPayload());

    $response->assertRedirect(route('fr.contact'))
        ->assertSessionHasErrors(['form' => 'Votre demande n’a pas pu être enregistrée. Veuillez réessayer dans quelques instants ou nous appeler au 07 80 64 73 27.'])
        ->assertInertiaFlashMissing('inquiry');
    $this->assertDatabaseCount('inquiries', 0);
    Mail::assertNothingSent();
    Log::shouldHaveReceived('error')->once()->withArgs(
        fn (string $message, array $context): bool => $message === 'A quote request could not be saved.'
            && ! str_contains((string) json_encode($context), 'jeanne.martin@example.com'),
    );
});

it('requires the mandatory fields', function () {
    $response = $this->post(route('fr.inquiries.store'), [
        'form_token' => Crypt::encryptString((string) now()->subMinute()->getTimestamp()),
    ]);

    $response->assertSessionHasErrors([
        'name' => 'Le champ nom complet est obligatoire.',
        'email' => 'Le champ adresse e-mail est obligatoire.',
        'phone' => 'Le champ téléphone est obligatoire.',
        'property_type' => 'Le champ type de logement est obligatoire.',
        'service' => 'Le champ prestation souhaitée est obligatoire.',
        'frequency' => 'Le champ fréquence est obligatoire.',
        'privacy_consent' => 'Veuillez accepter la politique de confidentialité pour envoyer votre demande.',
    ]);
    $response->assertSessionDoesntHaveErrors(['package', 'preferred_date', 'preferred_time_slot', 'property_size', 'rooms', 'message', 'form']);
    $this->assertDatabaseCount('inquiries', 0);
});

it('returns validation messages in English on the English website', function () {
    $response = $this->post(route('en.inquiries.store'), inquiryPayload(['name' => '', 'privacy_consent' => false]));

    $response->assertSessionHasErrors([
        'name' => 'The full name field is required.',
        'privacy_consent' => 'Please accept the privacy policy to send your request.',
    ]);
});

it('rejects invalid values', function (string $field, mixed $value, string $message) {
    $response = $this->post(route('fr.inquiries.store'), inquiryPayload([$field => $value]));

    $response->assertSessionHasErrors([$field => $message]);
    $this->assertDatabaseCount('inquiries', 0);
})->with([
    'malformed email' => ['email', 'jeanne.martin', 'Le champ adresse e-mail doit être une adresse e-mail valide.'],
    'phone without digits' => ['phone', 'appelez-moi', 'Veuillez indiquer un numéro de téléphone valide (par exemple 06 12 34 56 78).'],
    'unknown property type' => ['property_type', 'castle', 'La valeur sélectionnée pour type de logement n’est pas valide.'],
    'unknown service' => ['service', 'pool', 'La valeur sélectionnée pour prestation souhaitée n’est pas valide.'],
    'unknown package' => ['package', 'gold', 'La valeur sélectionnée pour formule n’est pas valide.'],
    'unknown frequency' => ['frequency', 'daily', 'La valeur sélectionnée pour fréquence n’est pas valide.'],
    'unknown time slot' => ['preferred_time_slot', 'night', 'La valeur sélectionnée pour créneau souhaité n’est pas valide.'],
    'date in the past' => ['preferred_date', '2020-01-01', 'Veuillez choisir une date à partir d’aujourd’hui.'],
    'date beyond a year' => ['preferred_date', '2099-01-01', 'Veuillez choisir une date dans les douze prochains mois.'],
    'oversized property' => ['property_size', 5000, 'Le champ surface ne doit pas être supérieur à 2000.'],
    'too many rooms' => ['rooms', 99, 'Le champ nombre de pièces ne doit pas être supérieur à 30.'],
    'overlong message' => ['message', str_repeat('a', 2001), 'Le champ précisions ne doit pas contenir plus de 2000 caractères.'],
    'unsupported language' => ['preferred_language', 'de', 'La valeur sélectionnée pour langue de contact n’est pas valide.'],
]);

it('defaults the contact language to the language of the website', function () {
    Mail::fake();

    $this->post(route('en.inquiries.store'), inquiryPayload(['preferred_language' => null]));

    expect(Inquiry::sole()->preferred_language)->toBe(Locale::English);
});

it('rejects automated submissions', function (array $overrides) {
    Mail::fake();

    $response = $this->post(route('fr.inquiries.store'), inquiryPayload($overrides));

    $response->assertSessionHasErrors(['form' => 'Votre demande n’a pas pu être envoyée. Veuillez réessayer.'])
        ->assertInertiaFlashMissing('inquiry');
    $this->assertDatabaseCount('inquiries', 0);
    Mail::assertNothingSent();
})->with([
    'honeypot filled in' => [fn (): array => ['website' => 'https://spam.example']],
    'form sent instantly' => [fn (): array => ['form_token' => Crypt::encryptString((string) now()->getTimestamp())]],
    'forged form token' => [fn (): array => ['form_token' => 'not-an-encrypted-timestamp']],
    'missing form token' => [fn (): array => ['form_token' => null]],
]);

it('limits repeated submissions from the same visitor', function () {
    Mail::fake();

    foreach (range(1, 8) as $attempt) {
        $this->post(route('fr.inquiries.store'), ['name' => '']);
    }

    $response = $this->post(route('fr.inquiries.store'), inquiryPayload());

    $response->assertSessionHasErrors([
        'form' => 'Plusieurs demandes ont été envoyées en peu de temps. Veuillez patienter avant de réessayer, ou appelez-nous au 07 80 64 73 27.',
    ]);
    $this->assertDatabaseCount('inquiries', 0);
});
