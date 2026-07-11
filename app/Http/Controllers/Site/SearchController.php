<?php

namespace App\Http\Controllers\Site;

use App\Http\Controllers\Controller;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\View\View;

class SearchController extends Controller
{
    public function index(Request $request): View
    {
        $query = trim((string) $request->input('q', ''));

        $products = $query === ''
            ? Product::query()->whereRaw('0 = 1')->paginate(12)
            : Product::with('category')
                ->where('status', true)
                ->where(function ($q) use ($query) {
                    $q->where('name', 'like', '%'.$query.'%')
                        ->orWhere('description', 'like', '%'.$query.'%');
                })
                ->orderBy('priority')
                ->latest()
                ->paginate(12)
                ->withQueryString();

        return view('site.search', [
            'products' => $products,
            'query' => $query,
        ]);
    }
}
