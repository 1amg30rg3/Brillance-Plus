@extends('mail.layout')

@section('title', __('mail.confirmation.subject'))

@section('content')
    <p style="margin:0 0 16px;font-size:16px;line-height:24px;font-weight:600;color:#0B1220;">{{ __('mail.confirmation.greeting', ['name' => $inquiry->name]) }}</p>
    <p style="margin:0 0 16px;font-size:15px;line-height:24px;">{{ __('mail.confirmation.intro') }}</p>

    <table role="presentation" width="100%" cellpadding="0" cellspacing="0" style="margin:0 0 24px;">
        <tr>
            <td style="background-color:#F0F9FF;border-left:3px solid #38BDF8;border-radius:8px;padding:14px 16px;font-size:14px;line-height:22px;color:#0F4C81;">
                {{ __('mail.confirmation.not_a_booking') }}<br>
                {{ __('mail.confirmation.payment') }}
            </td>
        </tr>
    </table>

    <h2 style="margin:0 0 8px;font-size:16px;line-height:24px;color:#0B1220;">{{ __('mail.confirmation.summary') }}</h2>
    @include('mail.inquiries.summary', ['summary' => $summary])

    <p style="margin:24px 0 4px;font-size:14px;line-height:22px;">{{ __('mail.confirmation.call', ['phone' => config('business.phone_display')]) }}</p>
    <p style="margin:16px 0 0;font-size:14px;line-height:22px;font-weight:600;">{{ __('mail.confirmation.signature') }}</p>
@endsection
