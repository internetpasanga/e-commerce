<?php

namespace App\Http\Controllers\Site;

use App\Http\Controllers\Controller;
use App\Models\Coupon;
use App\Support\Cart;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class CouponController extends Controller
{
    public function apply(Request $request): JsonResponse
    {
        $validated = $request->validate([
            'code' => ['required', 'string'],
        ]);

        $coupon = Coupon::whereRaw('UPPER(code) = ?', [strtoupper($validated['code'])])->first();

        if (! $coupon) {
            return response()->json(['message' => 'This coupon code is invalid.'], 422);
        }

        $error = $coupon->isValidFor(Cart::total(), $request->user());

        if ($error) {
            return response()->json(['message' => $error], 422);
        }

        $request->session()->put('applied_coupon', $coupon->code);

        return response()->json(['message' => 'Coupon applied successfully.']);
    }

    public function remove(Request $request): JsonResponse
    {
        $request->session()->forget('applied_coupon');

        return response()->json(['message' => 'Coupon removed.']);
    }
}
