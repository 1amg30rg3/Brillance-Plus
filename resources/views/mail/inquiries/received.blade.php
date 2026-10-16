@extends('mail.layout')

@section('title', __('mail.received.heading'))

@section('content')
    <h1 style="margin:0 0 12px;font-size:22px;line-height:30px;color:#0B1220;">{{ __('mail.received.heading') }}</h1>
    <p style="margin:0 0 8px;font-size:15px;line-height:24px;">{{ __('mail.received.intro') }}</p>
    <p style="margin:0 0 24px;font-size:13px;line-height:20px;color:#5B6880;">{{ __('mail.submitted_at', ['date' => $submittedAt]) }}</p>

    @include('mail.inquiries.summary', ['summary' => $summary])

    <p style="margin:24px 0 0;font-size:13px;line-height:20px;color:#0F4C81;">{{ __('mail.received.reply_hint') }}</p>
@endsection

@section('credit')
    {{ __('mail.received.credit', ['agency' => $agencyName]) }}
    <a href="{{ $agencyUrl }}" style="color:#0F4C81;text-decoration:underline;">{{ __('mail.received.credit_cta', ['agency' => $agencyName]) }}</a>
@endsection
