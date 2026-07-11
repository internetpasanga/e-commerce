<?php

namespace App\Support;

use App\Models\Coupon;
use App\Models\Setting;

class OrderTotals
{
    /**
     * @return array{totalMrp: float, total: float, savings: float, shippingCharge: ?float, couponCode: ?string, couponDiscount: float, grandTotal: float}
     */
    public static function forCart(?Coupon $coupon = null): array
    {
        $totalMrp = Cart::totalMrp();
        $total = Cart::total();
        $savings = Cart::savings();

        return static::withShipping($totalMrp, $total, $savings, $coupon);
    }

    /**
     * @param  array<int, array{mrp: float, sale_price: float, quantity: int, subtotal: float}>  $itemsData
     * @return array{totalMrp: float, total: float, savings: float, shippingCharge: ?float, couponCode: ?string, couponDiscount: float, grandTotal: float}
     */
    public static function forItems(array $itemsData, ?Coupon $coupon = null): array
    {
        $totalMrp = 0.0;
        $total = 0.0;

        foreach ($itemsData as $item) {
            $totalMrp += $item['mrp'] * $item['quantity'];
            $total += $item['subtotal'];
        }

        $savings = $totalMrp - $total;

        return static::withShipping($totalMrp, $total, $savings, $coupon);
    }

    /**
     * @return array{totalMrp: float, total: float, savings: float, shippingCharge: ?float, couponCode: ?string, couponDiscount: float, grandTotal: float}
     */
    private static function withShipping(float $totalMrp, float $total, float $savings, ?Coupon $coupon = null): array
    {
        $configuredShipping = Setting::get('shipping_charge');
        $shippingCharge = ($configuredShipping !== null && $configuredShipping !== '') ? (float) $configuredShipping : null;

        $couponCode = null;
        $couponDiscount = 0.0;

        if ($coupon !== null) {
            $couponCode = $coupon->code;
            $couponDiscount = $coupon->calculateDiscount($total);
        }

        $grandTotal = $total - $couponDiscount + ($shippingCharge ?? 0);

        return compact('totalMrp', 'total', 'savings', 'shippingCharge', 'couponCode', 'couponDiscount', 'grandTotal');
    }
}
