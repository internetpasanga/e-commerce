<?php

namespace App\Http\Controllers\Site;

use App\Http\Controllers\Controller;
use App\Models\Coupon;
use App\Models\Product;
use App\Support\Cart;
use App\Support\OrderTotals;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class CartController extends Controller
{
    public function index(Request $request): View
    {
        $items = Cart::contents();
        $coupon = Coupon::resolveApplied($request, Cart::total());
        $data = ['items' => $items] + OrderTotals::forCart($coupon);

        if ($request->ajax()) {
            return view('site.partials._cart-items', $data);
        }

        return view('site.cart', $data);
    }

    public function store(Request $request, Product $product): JsonResponse
    {
        $quantity = max(1, (int) $request->input('quantity', 1));

        if ($product->stock < 1) {
            return response()->json(['message' => 'This product is out of stock.'], 422);
        }

        Cart::add($product->id, min($quantity, $product->stock));

        return response()->json([
            'message' => 'Added to cart.',
            'count' => Cart::count(),
        ]);
    }

    public function update(Request $request, Product $product): JsonResponse
    {
        $quantity = (int) $request->input('quantity', 1);

        Cart::update($product->id, min($quantity, $product->stock));

        return response()->json([
            'message' => 'Cart updated.',
            'count' => Cart::count(),
            'total' => Cart::total(),
        ]);
    }

    public function destroy(Product $product): JsonResponse
    {
        Cart::remove($product->id);

        return response()->json([
            'message' => 'Item removed from cart.',
            'count' => Cart::count(),
            'total' => Cart::total(),
        ]);
    }
}
