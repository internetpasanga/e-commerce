<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Product;
use App\Models\ProductImage;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rule;
use Illuminate\View\View;

class ProductController extends Controller
{
    public function index(Request $request): View
    {
        $products = Product::with('category')
            ->when($request->filled('search'), fn ($query) => $query->where('name', 'like', '%'.$request->input('search').'%'))
            ->when($request->filled('category_id'), fn ($query) => $query->where('category_id', $request->input('category_id')))
            ->when($request->filled('status'), fn ($query) => $query->where('status', $request->input('status')))
            ->orderBy('priority')
            ->latest()
            ->paginate(10)
            ->withQueryString();

        if ($request->ajax()) {
            return view('admin.products._table', compact('products'));
        }

        $categories = Category::orderBy('name')->get();

        return view('admin.products.index', compact('products', 'categories'));
    }

    public function create(): View
    {
        $categories = Category::orderBy('name')->get();
        $allProducts = Product::orderBy('name')->get(['id', 'name']);

        return view('admin.products.create', compact('categories', 'allProducts'));
    }

    public function edit(Product $product): View
    {
        $product->load('images', 'relatedProducts', 'specifications');
        $categories = Category::orderBy('name')->get();
        $allProducts = Product::orderBy('name')->get(['id', 'name']);

        return view('admin.products.edit', compact('product', 'categories', 'allProducts'));
    }

    public function store(Request $request): RedirectResponse
    {
        $validated = $this->validateProduct($request);

        if ($request->hasFile('thumbnail')) {
            $validated['thumbnail'] = $request->file('thumbnail')->store('products', 'public');
        }

        $product = Product::create($validated);

        $this->storeImages($request, $product);
        $this->syncRelatedProducts($request, $product);
        $this->syncSpecifications($request, $product);

        return redirect()->route('admin.products.index')->with('status', 'Product created successfully.');
    }

    public function update(Request $request, Product $product): RedirectResponse
    {
        $validated = $this->validateProduct($request, $product);

        if ($request->hasFile('thumbnail')) {
            if ($product->thumbnail) {
                Storage::disk('public')->delete($product->thumbnail);
            }

            $validated['thumbnail'] = $request->file('thumbnail')->store('products', 'public');
        }

        $product->update($validated);

        $this->storeImages($request, $product);
        $this->syncRelatedProducts($request, $product);
        $this->syncSpecifications($request, $product);

        return redirect()->route('admin.products.index')->with('status', 'Product updated successfully.');
    }

    public function destroy(Product $product): JsonResponse
    {
        if ($product->thumbnail) {
            Storage::disk('public')->delete($product->thumbnail);
        }

        $product->images->each(fn (ProductImage $image) => Storage::disk('public')->delete($image->image));

        $product->delete();

        return response()->json(['message' => 'Product deleted successfully.']);
    }

    public function destroyImage(Product $product, ProductImage $image): JsonResponse
    {
        abort_if($image->product_id !== $product->id, 404);

        Storage::disk('public')->delete($image->image);
        $image->delete();

        return response()->json(['message' => 'Image removed successfully.']);
    }

    private function storeImages(Request $request, Product $product): void
    {
        if (! $request->hasFile('images')) {
            return;
        }

        foreach ($request->file('images') as $file) {
            $product->images()->create([
                'image' => $file->store('products', 'public'),
            ]);
        }
    }

    private function syncRelatedProducts(Request $request, Product $product): void
    {
        $relatedIds = collect($request->input('related_products', []))
            ->reject(fn ($id) => (int) $id === $product->id)
            ->values()
            ->all();

        $product->relatedProducts()->sync($relatedIds);
    }

    private function syncSpecifications(Request $request, Product $product): void
    {
        $keys = $request->input('specification_keys', []);
        $values = $request->input('specification_values', []);

        $product->specifications()->delete();

        $sortOrder = 0;

        foreach ($keys as $index => $key) {
            $key = trim((string) $key);
            $value = trim((string) ($values[$index] ?? ''));

            if ($key === '' || $value === '') {
                continue;
            }

            $product->specifications()->create([
                'key' => $key,
                'value' => $value,
                'sort_order' => $sortOrder++,
            ]);
        }
    }

    private function validateProduct(Request $request, ?Product $product = null): array
    {
        return $request->validate([
            'name' => ['required', 'string', 'max:255', Rule::unique('products')->ignore($product)],
            'category_id' => ['required', 'exists:categories,id'],
            'description' => ['nullable', 'string'],
            'mrp' => ['required', 'numeric', 'min:0'],
            'sale_price' => ['required', 'numeric', 'min:0', 'lte:mrp'],
            'stock' => ['required', 'integer', 'min:0'],
            'thumbnail' => ['nullable', 'image', 'max:2048'],
            'images' => ['nullable', 'array'],
            'images.*' => ['image', 'max:2048'],
            'related_products' => ['nullable', 'array'],
            'related_products.*' => ['integer', 'exists:products,id'],
            'specification_keys' => ['nullable', 'array'],
            'specification_keys.*' => ['nullable', 'string', 'max:100'],
            'specification_values' => ['nullable', 'array'],
            'specification_values.*' => ['nullable', 'string', 'max:255'],
            'status' => ['sometimes', 'boolean'],
            'priority' => ['nullable', 'integer', 'min:0'],
        ]) + ['status' => $request->boolean('status')];
    }
}
