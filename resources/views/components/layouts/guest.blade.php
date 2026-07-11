<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ $title ?? ($siteSettings['site_name'] ?? config('app.name')) }}</title>
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
</head>
<body>
    <div class="guest-wrapper">
        <div class="guest-card">
            {{ $slot }}
        </div>
    </div>
</body>
</html>
