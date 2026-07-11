<?php

namespace App\Http\Controllers\Site;

use App\Http\Controllers\Controller;
use App\Models\Banner;
use App\Models\Category;
use App\Models\Product;
use Illuminate\View\View;

class HomeController extends Controller
{
    public function index(): View
    {
        $banners = Banner::where('status', true)->orderBy('priority')->get();
        $categories = Category::where('status', true)->orderBy('priority')->get();
        $products = Product::with('category')
            ->where('status', true)
            ->orderBy('priority')
            ->latest()
            ->take(8)
            ->get();

        return view('site.home', compact('banners', 'categories', 'products'));
    }
}
