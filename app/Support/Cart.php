<?php

namespace App\Support;

use App\Models\CartItem;
use App\Models\Product;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Auth;

class Cart
{
    protected const SESSION_KEY = 'cart';

    public static function add(int $productId, int $quantity = 1): void
    {
        $quantity = max(1, $quantity);

        if (Auth::check()) {
            $item = CartItem::firstOrNew(['user_id' => Auth::id(), 'product_id' => $productId]);
            $item->quantity = ($item->exists ? $item->quantity : 0) + $quantity;
            $item->save();

            return;
        }

        $items = static::items();
        $items[$productId] = ($items[$productId] ?? 0) + $quantity;
        session([self::SESSION_KEY => $items]);
    }

    public static function update(int $productId, int $quantity): void
    {
        if (Auth::check()) {
            if ($quantity <= 0) {
                CartItem::where('user_id', Auth::id())->where('product_id', $productId)->delete();
            } else {
                CartItem::updateOrCreate(
                    ['user_id' => Auth::id(), 'product_id' => $productId],
                    ['quantity' => $quantity]
                );
            }

            return;
        }

        $items = static::items();

        if ($quantity <= 0) {
            unset($items[$productId]);
        } else {
            $items[$productId] = $quantity;
        }

        session([self::SESSION_KEY => $items]);
    }

    public static function remove(int $productId): void
    {
        if (Auth::check()) {
            CartItem::where('user_id', Auth::id())->where('product_id', $productId)->delete();

            return;
        }

        $items = static::items();
        unset($items[$productId]);
        session([self::SESSION_KEY => $items]);
    }

    public static function count(): int
    {
        if (Auth::check()) {
            return (int) CartItem::where('user_id', Auth::id())->sum('quantity');
        }

        return array_sum(static::items());
    }

    public static function contents(): Collection
    {
        if (Auth::check()) {
            return CartItem::with('product.category')
                ->where('user_id', Auth::id())
                ->get()
                ->map(fn (CartItem $item) => static::toLineItem($item->product, $item->quantity))
                ->filter()
                ->values();
        }

        $items = static::items();

        if (empty($items)) {
            return collect();
        }

        $products = Product::with('category')->whereIn('id', array_keys($items))->get()->keyBy('id');

        return collect($items)
            ->map(fn ($quantity, $productId) => static::toLineItem($products->get($productId), $quantity))
            ->filter()
            ->values();
    }

    public static function total(): float
    {
        return (float) static::contents()->sum('subtotal');
    }

    public static function totalMrp(): float
    {
        return (float) static::contents()->sum('mrp_subtotal');
    }

    public static function savings(): float
    {
        return (float) static::contents()->sum(fn ($item) => $item['mrp_subtotal'] - $item['subtotal']);
    }

    public static function clear(): void
    {
        if (Auth::check()) {
            CartItem::where('user_id', Auth::id())->delete();

            return;
        }

        session()->forget(self::SESSION_KEY);
    }

    /**
     * Merge the guest session cart into the authenticated user's database cart.
     */
    public static function mergeSessionIntoDatabase(int $userId): void
    {
        $items = static::items();

        foreach ($items as $productId => $quantity) {
            $item = CartItem::firstOrNew(['user_id' => $userId, 'product_id' => $productId]);
            $item->quantity = ($item->exists ? $item->quantity : 0) + $quantity;
            $item->save();
        }

        session()->forget(self::SESSION_KEY);
    }

    protected static function toLineItem(?Product $product, int $quantity): ?array
    {
        if (! $product) {
            return null;
        }

        return [
            'product' => $product,
            'quantity' => $quantity,
            'subtotal' => $product->sale_price * $quantity,
            'mrp_subtotal' => $product->mrp * $quantity,
        ];
    }

    protected static function items(): array
    {
        return session(self::SESSION_KEY, []);
    }
}
