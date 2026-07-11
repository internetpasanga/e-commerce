<?php

namespace App\Support;

use App\Models\Setting;

class GoogleAuth
{
    public static function clientId(): ?string
    {
        return Setting::get('google_client_id') ?: null;
    }

    public static function clientSecret(): ?string
    {
        return Setting::get('google_client_secret') ?: null;
    }

    public static function isConfigured(): bool
    {
        return ! empty(static::clientId()) && ! empty(static::clientSecret());
    }
}
