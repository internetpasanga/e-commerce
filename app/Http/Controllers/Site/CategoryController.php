<?php

namespace App\Http\Controllers\Site;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Support\ProductSorter;
use Illuminate\Http\Request;
use Illuminate\View\View;

class CategoryController extends Controller
{
    public function show(Request $request, Category $category): View
    {
        $categories = Category::where('status', true)->orderBy('priority')->get();

        $min = $request->filled('min') ? (float) $request->input('min') : null;
        $max = $request->filled('max') ? (float) $request->input('max') : null;
        $sort = $request->input('sort', 'featured');

        $query = $category->products()->with('category')->where('status', true);

        if ($min !== null) {
            $query->where('sale_price', '>=', $min);
        }

        if ($max !== null) {
            $query->where('sale_price', '<=', $max);
        }

        ProductSorter::apply($query, $sort);

        $products = $query->paginate(12)->withQueryString();

        return view('site.category', [
            'category' => $category,
            'products' => $products,
            'categories' => $categories,
            'activeCategory' => $category->id,
            'min' => $min,
            'max' => $max,
            'sort' => $sort,
            'filterAction' => route('category.show', $category),
        ]);
    }
}
