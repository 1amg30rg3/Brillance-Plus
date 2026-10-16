<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="color-scheme" content="light">
    <title>@yield('title')</title>
</head>
<body style="margin:0;padding:0;background-color:#F4F8FC;font-family:-apple-system,BlinkMacSystemFont,'Segoe UI',Roboto,Helvetica,Arial,sans-serif;color:#172033;">
    <table role="presentation" width="100%" cellpadding="0" cellspacing="0" style="background-color:#F4F8FC;padding:32px 12px;">
        <tr>
            <td align="center">
                <table role="presentation" width="100%" cellpadding="0" cellspacing="0" style="max-width:600px;">
                    <tr>
                        <td style="padding:0 8px 20px;font-size:20px;font-weight:600;letter-spacing:-0.01em;color:#0B1220;">
                            <span style="color:#38BDF8;">&#10022;</span> Brillance <span style="color:#0F4C81;">Plus</span>
                        </td>
                    </tr>
                    <tr>
                        <td style="background-color:#FFFFFF;border:1px solid #E2E9F2;border-radius:16px;padding:32px 28px;">
                            @yield('content')
                        </td>
                    </tr>
                    <tr>
                        <td style="padding:20px 8px 0;font-size:12px;line-height:18px;color:#5B6880;">
                            {{ __('mail.footer', ['url' => config('app.url')]) }}
                        </td>
                    </tr>
                    @hasSection('credit')
                        <tr>
                            <td style="padding:8px 8px 0;font-size:12px;line-height:18px;color:#5B6880;">
                                @yield('credit')
                            </td>
                        </tr>
                    @endif
                </table>
            </td>
        </tr>
    </table>
</body>
</html>
