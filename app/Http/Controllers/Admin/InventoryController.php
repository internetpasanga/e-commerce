<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\Setting;
use App\Models\StockMovement;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\ValidationException;
use Illuminate\View\View;

class InventoryController extends Controller
{
    public function index(Request $request): View
    {
        $threshold = (int) Setting::get('low_stock_threshold', 5);

        $products = Product::with('category')
            ->when($request->filled('search'), fn ($q) => $q->where('name', 'like', '%'.$request->input('search').'%'))
            ->when($request->boolean('low_stock'), fn ($q) => $q->where('stock', '<=', $threshold))
            ->orderBy('stock')
            ->latest()
            ->paginate(15)
            ->withQueryString();

        return view('admin.inventory.index', compact('products', 'threshold'));
    }

    public function show(Product $product): View
    {
        $product->load('stockMovements.changedBy', 'stockMovements.order');

        return view('admin.inventory.show', compact('product'));
    }

    public function adjust(Request $request, Product $product): RedirectResponse
    {
        $validated = $request->validate([
            'direction' => ['required', 'in:add,remove'],
            'quantity' => ['required', 'integer', 'min:1'],
            'note' => ['nullable', 'string', 'max:1000'],
        ]);

        DB::transaction(function () use ($request, $product, $validated) {
            $locked = Product::whereKey($product->id)->lockForUpdate()->first();

            if ($validated['direction'] === 'remove' && $locked->stock < $validated['quantity']) {
                throw ValidationException::withMessages([
                    'quantity' => "Cannot remove more than the current stock ({$locked->stock}).",
                ]);
            }

            if ($validated['direction'] === 'add') {
                $locked->increment('stock', $validated['quantity']);
                $quantityChange = $validated['quantity'];
            } else {
                $locked->decrement('stock', $validated['quantity']);
                $quantityChange = -$validated['quantity'];
            }

            StockMovement::create([
                'product_id' => $locked->id,
                'changed_by' => $request->user()->id,
                'quantity_change' => $quantityChange,
                'stock_after' => $locked->stock,
                'reason' => 'Manual adjustment',
                'note' => $validated['note'] ?? null,
            ]);
        });

        return back()->with('status', 'Stock adjusted successfully.');
    }
}
