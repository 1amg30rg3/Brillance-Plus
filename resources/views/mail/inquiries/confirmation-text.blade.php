{!! __('mail.confirmation.greeting', ['name' => $inquiry->name]) !!}

{!! __('mail.confirmation.intro') !!}

{!! __('mail.confirmation.not_a_booking') !!}
{!! __('mail.confirmation.payment') !!}

{!! __('mail.confirmation.summary') !!}
@foreach ($summary as $label => $value)
{!! __('mail.row', ['label' => $label, 'value' => $value]) !!}
@endforeach

{!! __('mail.confirmation.call', ['phone' => config('business.phone_display')]) !!}

{!! __('mail.confirmation.signature') !!}
