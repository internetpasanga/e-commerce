<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Http\Request;

class Coupon extends Model
{
    public const TYPES = ['percentage', 'fixed'];

    protected $fillable = [
        'code',
        'type',
        'value',
        'max_discount',
        'min_order_amount',
        'usage_limit',
        'used_count',
        'per_customer_limit',
        'starts_at',
        'expires_at',
        'is_active',
    ];

    protected function casts(): array
    {
        return [
            'value' => 'decimal:2',
            'max_discount' => 'decimal:2',
            'min_order_amount' => 'decimal:2',
            'usage_limit' => 'integer',
            'used_count' => 'integer',
            'per_customer_limit' => 'integer',
            'starts_at' => 'datetime',
            'expires_at' => 'datetime',
            'is_active' => 'boolean',
        ];
    }

    public function usages(): HasMany
    {
        return $this->hasMany(CouponUsage::class);
    }

    /**
     * Resolve the coupon currently applied in the session, re-validating it against the
     * live cart subtotal so a coupon that's since become invalid is silently dropped.
     */
    public static function resolveApplied(Request $request, float $subtotal): ?self
    {
        $code = $request->session()->get('applied_coupon');

        if (! $code) {
            return null;
        }

        $coupon = static::whereRaw('UPPER(code) = ?', [strtoupper($code)])->first();

        if (! $coupon || $coupon->isValidFor($subtotal, $request->user())) {
            $request->session()->forget('applied_coupon');

            return null;
        }

        return $coupon;
    }

    public function calculateDiscount(float $subtotal): float
    {
        if ($this->type === 'fixed') {
            return min((float) $this->value, $subtotal);
        }

        $discount = $subtotal * ((float) $this->value / 100);

        if ($this->max_discount !== null) {
            $discount = min($discount, (float) $this->max_discount);
        }

        return min($discount, $subtotal);
    }

    public function isValidFor(float $subtotal, ?User $user = null): ?string
    {
        if (! $this->is_active) {
            return 'This coupon is no longer active.';
        }

        if ($this->starts_at && now()->lt($this->starts_at)) {
            return 'This coupon is not active yet.';
        }

        if ($this->expires_at && now()->gt($this->expires_at)) {
            return 'This coupon has expired.';
        }

        if ($this->min_order_amount !== null && $subtotal < (float) $this->min_order_amount) {
            return 'This coupon requires a minimum order of ₹'.number_format((float) $this->min_order_amount, 2).'.';
        }

        if ($this->usage_limit !== null && $this->used_count >= $this->usage_limit) {
            return 'This coupon has reached its usage limit.';
        }

        if ($user && $this->per_customer_limit !== null) {
            $usedByCustomer = $this->usages()->where('user_id', $user->id)->count();

            if ($usedByCustomer >= $this->per_customer_limit) {
                return 'You have already used this coupon.';
            }
        }

        return null;
    }
}
