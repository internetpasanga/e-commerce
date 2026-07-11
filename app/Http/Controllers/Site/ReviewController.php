<?php

namespace App\Http\Controllers\Site;

use App\Http\Controllers\Controller;
use App\Models\OrderItem;
use App\Models\Product;
use App\Models\Review;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class ReviewController extends Controller
{
    public function index(Request $request): View
    {
        $reviews = $request->user()->reviews()->with('product')->latest()->paginate(10);

        return view('site.reviews.index', compact('reviews'));
    }

    public function store(Request $request, Product $product): RedirectResponse
    {
        $user = $request->user();

        if (Review::where('user_id', $user->id)->where('product_id', $product->id)->exists()) {
            return back()->withErrors(['review' => 'You have already reviewed this product.']);
        }

        $orderItem = OrderItem::whereHas('order', function ($query) use ($user) {
            $query->where('user_id', $user->id)->where('status', 'delivered');
        })->where('product_id', $product->id)->first();

        if (! $orderItem) {
            return back()->withErrors(['review' => 'Only customers who have received this product can leave a review.']);
        }

        $validated = $request->validate([
            'rating' => ['required', 'integer', 'between:1,5'],
            'comment' => ['required', 'string', 'max:2000'],
        ]);

        Review::create([
            'product_id' => $product->id,
            'user_id' => $user->id,
            'order_id' => $orderItem->order_id,
            'rating' => $validated['rating'],
            'comment' => $validated['comment'],
            'status' => 'pending',
        ]);

        return back()->with('status', 'Thanks! Your review has been submitted and is awaiting approval.');
    }
}
