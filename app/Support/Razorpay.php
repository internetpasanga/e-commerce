<?php

namespace App\Support;

use App\Models\Setting;
use Razorpay\Api\Api;

class Razorpay
{
    public static function client(): Api
    {
        return new Api(static::keyId(), static::keySecret());
    }

    public static function keyId(): ?string
    {
        $mode = static::mode();

        return Setting::get("razorpay_{$mode}_key_id") ?: null;
    }

    public static function keySecret(): ?string
    {
        $mode = static::mode();

        return Setting::get("razorpay_{$mode}_key_secret") ?: null;
    }

    public static function isConfigured(): bool
    {
        return ! empty(static::keyId()) && ! empty(static::keySecret());
    }

    protected static function mode(): string
    {
        return Setting::get('razorpay_mode', 'test') === 'live' ? 'live' : 'test';
    }
}
