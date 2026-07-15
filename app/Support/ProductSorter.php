<?php

namespace App\Support;

use Illuminate\Database\Eloquent\Builder;

class ProductSorter
{
    /**
     * Sort options shared by the shop and category listings:
     * value => human label.
     *
     * @var array<string, string>
     */
    public const OPTIONS = [
        'featured' => 'Featured',
        'price_asc' => 'Price: Low to High',
        'price_desc' => 'Price: High to Low',
        'discount' => 'Discount',
        'newest' => 'Newest Arrivals',
    ];

    /**
     * Apply a sort option to a product query.
     */
    public static function apply(Builder $query, ?string $sort): void
    {
        match ($sort) {
            'price_asc' => $query->orderBy('sale_price'),
            'price_desc' => $query->orderByDesc('sale_price'),
            'discount' => $query->orderByRaw('(mrp - sale_price) / NULLIF(mrp, 0) DESC'),
            'newest' => $query->latest(),
            default => $query->orderBy('priority')->latest(),
        };
    }
}
