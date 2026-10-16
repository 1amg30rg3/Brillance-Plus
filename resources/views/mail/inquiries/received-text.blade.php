{!! __('mail.received.heading') !!}

{!! __('mail.received.intro') !!}
{!! __('mail.submitted_at', ['date' => $submittedAt]) !!}

@foreach ($summary as $label => $value)
{!! __('mail.row', ['label' => $label, 'value' => $value]) !!}
@endforeach

{!! __('mail.received.reply_hint') !!}

--
{!! __('mail.received.credit', ['agency' => $agencyName]) !!}
{!! __('mail.received.credit_cta', ['agency' => $agencyName]) !!}
{!! $agencyUrl !!}
