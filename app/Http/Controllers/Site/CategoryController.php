<?php

namespace App\Http\Controllers\Site;

use App\Http\Controllers\Controller;
use App\Models\Category;
use Illuminate\View\View;

class CategoryController extends Controller
{
    public function show(Category $category): View
    {
        $products = $category->products()
            ->where('status', true)
            ->orderBy('priority')
            ->paginate(12);

        return view('site.category', compact('category', 'products'));
    }
}
