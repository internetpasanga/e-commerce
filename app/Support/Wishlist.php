<?php

namespace App\Support;

use App\Models\Product;
use App\Models\WishlistItem;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Auth;

class Wishlist
{
    protected const SESSION_KEY = 'wishlist';

    public static function toggle(int $productId): bool
    {
        if (Auth::check()) {
            $item = WishlistItem::where('user_id', Auth::id())->where('product_id', $productId)->first();

            if ($item) {
                $item->delete();

                return false;
            }

            WishlistItem::create(['user_id' => Auth::id(), 'product_id' => $productId]);

            return true;
        }

        $items = static::items();

        if (in_array($productId, $items, true)) {
            $items = array_values(array_diff($items, [$productId]));
            session([self::SESSION_KEY => $items]);

            return false;
        }

        $items[] = $productId;
        session([self::SESSION_KEY => $items]);

        return true;
    }

    public static function remove(int $productId): void
    {
        if (Auth::check()) {
            WishlistItem::where('user_id', Auth::id())->where('product_id', $productId)->delete();

            return;
        }

        $items = array_values(array_diff(static::items(), [$productId]));
        session([self::SESSION_KEY => $items]);
    }

    public static function has(int $productId): bool
    {
        if (Auth::check()) {
            return WishlistItem::where('user_id', Auth::id())->where('product_id', $productId)->exists();
        }

        return in_array($productId, static::items(), true);
    }

    public static function count(): int
    {
        if (Auth::check()) {
            return WishlistItem::where('user_id', Auth::id())->count();
        }

        return count(static::items());
    }

    public static function contents(): Collection
    {
        if (Auth::check()) {
            return Product::with('category')
                ->whereIn('id', WishlistItem::where('user_id', Auth::id())->pluck('product_id'))
                ->get();
        }

        $items = static::items();

        if (empty($items)) {
            return collect();
        }

        return Product::with('category')->whereIn('id', $items)->get();
    }

    /**
     * Merge the guest session wishlist into the authenticated user's database wishlist.
     */
    public static function mergeSessionIntoDatabase(int $userId): void
    {
        foreach (static::items() as $productId) {
            WishlistItem::firstOrCreate(['user_id' => $userId, 'product_id' => $productId]);
        }

        session()->forget(self::SESSION_KEY);
    }

    protected static function items(): array
    {
        return session(self::SESSION_KEY, []);
    }
}
