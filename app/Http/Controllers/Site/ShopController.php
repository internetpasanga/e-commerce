<?php

namespace App\Http\Controllers\Site;

use App\Http\Controllers\Controller;
use App\Models\Product;
use Illuminate\View\View;

class ShopController extends Controller
{
    public function index(): View
    {
        $products = Product::with('category')
            ->where('status', true)
            ->orderBy('priority')
            ->latest()
            ->paginate(12)
            ->withQueryString();

        return view('site.shop', compact('products'));
    }
}
