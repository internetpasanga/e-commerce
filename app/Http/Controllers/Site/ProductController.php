<?php

namespace App\Http\Controllers\Site;

use App\Http\Controllers\Controller;
use App\Models\OrderItem;
use App\Models\Product;
use App\Models\Review;
use Illuminate\Support\Collection;
use Illuminate\View\View;

class ProductController extends Controller
{
    public function show(Product $product): View
    {
        $product->load('images', 'category', 'approvedReviews.user', 'specifications');

        $alreadyReviewed = false;
        $canReview = false;

        if (auth()->check()) {
            $userId = auth()->id();

            $alreadyReviewed = Review::where('user_id', $userId)->where('product_id', $product->id)->exists();

            if (! $alreadyReviewed) {
                $canReview = OrderItem::whereHas('order', function ($query) use ($userId) {
                    $query->where('user_id', $userId)->where('status', 'delivered');
                })->where('product_id', $product->id)->exists();
            }
        }

        $relatedProducts = $this->relatedProductsFor($product);

        return view('site.product', compact('product', 'alreadyReviewed', 'canReview', 'relatedProducts'));
    }

    /**
     * Admin-curated related products, filled out with other products from the
     * same category when there aren't enough to make a full row.
     */
    private function relatedProductsFor(Product $product, int $limit = 4): Collection
    {
        $related = $product->relatedProducts()->with('category')->where('status', true)->get();

        if ($related->count() < $limit) {
            $excludeIds = $related->pluck('id')->push($product->id);

            $fallback = Product::with('category')
                ->where('category_id', $product->category_id)
                ->where('status', true)
                ->whereNotIn('id', $excludeIds)
                ->latest()
                ->take($limit - $related->count())
                ->get();

            $related = $related->concat($fallback);
        }

        return $related->take($limit);
    }
}
