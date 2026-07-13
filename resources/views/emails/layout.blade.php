@php
    $siteName = $siteName ?? config('app.name');
    $logoUrl = $logoUrl ?? null;
    $primaryColor = $primaryColor ?? '#4f46e5';
    $address = $address ?? null;
    $phone = $phone ?? null;
    $email = $email ?? null;
    $socialLinks = array_filter([
        'Facebook' => $socialFacebook ?? null,
        'Instagram' => $socialInstagram ?? null,
        'Twitter' => $socialTwitter ?? null,
        'YouTube' => $socialYoutube ?? null,
    ]);
@endphp
<!DOCTYPE html>
<html lang="en" xmlns="http://www.w3.org/1999/xhtml" xmlns:v="urn:schemas-microsoft-com:vml" xmlns:o="urn:schemas-microsoft-com:office:office">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="color-scheme" content="light">
    <meta name="format-detection" content="telephone=no, date=no, address=no, email=no">
    <title>{{ $siteName }}</title>
    <!--[if mso]>
    <noscript>
        <xml>
            <o:OfficeDocumentSettings>
                <o:PixelsPerInch>96</o:PixelsPerInch>
            </o:OfficeDocumentSettings>
        </xml>
    </noscript>
    <![endif]-->
    <style>
        body, table, td { font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, Helvetica, Arial, sans-serif; }
        a { color: {{ $primaryColor }}; }
        img { -ms-interpolation-mode: bicubic; }
        @media only screen and (max-width: 600px) {
            .email-container { width: 100% !important; }
            .email-content, .email-header, .email-footer { padding-left: 24px !important; padding-right: 24px !important; }
        }
    </style>
</head>
<body style="margin:0; padding:0; background-color:#eef0f3; -webkit-font-smoothing:antialiased;">
    <div style="display:none; max-height:0; overflow:hidden; mso-hide:all; opacity:0;">{{ $preheader ?? '' }}&nbsp;&zwnj;&nbsp;&zwnj;&nbsp;&zwnj;&nbsp;&zwnj;&nbsp;&zwnj;&nbsp;&zwnj;&nbsp;&zwnj;&nbsp;&zwnj;</div>

    <table role="presentation" width="100%" cellpadding="0" cellspacing="0" style="background-color:#eef0f3; padding:40px 16px;">
        <tr>
            <td align="center">

                <table role="presentation" class="email-container" width="600" cellpadding="0" cellspacing="0" style="width:600px; max-width:100%;">
                    <tr>
                        <td align="center" style="padding:0 0 20px;">
                            <span style="font-size:13px; font-weight:600; color:#667085; letter-spacing:0.2px;">{{ $siteName }}</span>
                        </td>
                    </tr>
                </table>

                <table role="presentation" class="email-container" width="600" cellpadding="0" cellspacing="0" style="width:600px; max-width:100%; background-color:#ffffff; border-radius:12px; border:1px solid #e4e7ec; box-shadow:0 2px 8px rgba(16,24,40,0.04);">

                    <tr>
                        <td style="background-color:{{ $primaryColor }}; height:4px; line-height:4px; font-size:0; border-radius:12px 12px 0 0;">&nbsp;</td>
                    </tr>

                    <tr>
                        <td class="email-header" align="center" style="padding:36px 40px 24px; border-bottom:1px solid #f0f1f3;">
                            @if ($logoUrl)
                                <img src="{{ $logoUrl }}" alt="{{ $siteName }}" height="32" style="height:32px; max-width:200px; display:block; border:0;">
                            @else
                                <span style="font-size:19px; font-weight:700; color:#101828; letter-spacing:0.1px;">{{ $siteName }}</span>
                            @endif
                        </td>
                    </tr>

                    <tr>
                        <td class="email-content" style="padding:40px; font-size:15px; line-height:1.65; color:#344054;">
                            {!! $slot !!}
                        </td>
                    </tr>

                    <tr>
                        <td style="padding:0 40px;">
                            <table role="presentation" width="100%" cellpadding="0" cellspacing="0"><tr><td style="border-top:1px solid #f0f1f3; font-size:0; line-height:0;">&nbsp;</td></tr></table>
                        </td>
                    </tr>

                    <tr>
                        <td class="email-footer" align="center" style="padding:28px 40px 36px;">
                            @if ($address)
                                <p style="margin:0 0 4px; font-size:12px; color:#98a2b3;">{{ $address }}</p>
                            @endif

                            @if ($phone || $email)
                                <p style="margin:0 0 14px; font-size:12px; color:#98a2b3;">
                                    @if ($phone)
                                        {{ $phone }}
                                    @endif
                                    @if ($phone && $email)
                                        &nbsp;&middot;&nbsp;
                                    @endif
                                    @if ($email)
                                        {{ $email }}
                                    @endif
                                </p>
                            @endif

                            @if (count($socialLinks) > 0)
                                <p style="margin:0 0 16px; font-size:12px;">
                                    @foreach ($socialLinks as $label => $url)
                                        <a href="{{ $url }}" style="color:{{ $primaryColor }}; text-decoration:none; font-weight:600; margin:0 8px;">{{ $label }}</a>@if (! $loop->last)<span style="color:#d0d5dd;">&middot;</span>@endif
                                    @endforeach
                                </p>
                            @endif

                            <p style="margin:0; font-size:11px; color:#b4b9c2;">&copy; {{ now()->year }} {{ $siteName }}. All rights reserved.</p>
                            <p style="margin:6px 0 0; font-size:11px; color:#b4b9c2;">This is an automated message — please do not reply directly to this email.</p>
                        </td>
                    </tr>

                </table>
            </td>
        </tr>
    </table>
</body>
</html>
