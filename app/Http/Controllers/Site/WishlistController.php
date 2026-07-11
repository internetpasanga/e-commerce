<?php

namespace App\Http\Controllers\Site;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Support\Wishlist;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class WishlistController extends Controller
{
    public function index(Request $request): View
    {
        $items = Wishlist::contents();

        if ($request->ajax()) {
            return view('site.partials._wishlist-items', compact('items'));
        }

        return view('site.wishlist', compact('items'));
    }

    public function toggle(Product $product): JsonResponse
    {
        $added = Wishlist::toggle($product->id);

        return response()->json([
            'added' => $added,
            'count' => Wishlist::count(),
            'message' => $added ? 'Added to wishlist.' : 'Removed from wishlist.',
        ]);
    }

    public function destroy(Product $product): JsonResponse
    {
        Wishlist::remove($product->id);

        return response()->json([
            'message' => 'Removed from wishlist.',
            'count' => Wishlist::count(),
        ]);
    }
}
