<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Str;

class Product extends Model
{
    protected $fillable = [
        'category_id',
        'name',
        'slug',
        'description',
        'mrp',
        'sale_price',
        'stock',
        'thumbnail',
        'priority',
        'status',
    ];

    protected function casts(): array
    {
        return [
            'status' => 'boolean',
            'priority' => 'integer',
            'mrp' => 'decimal:2',
            'sale_price' => 'decimal:2',
            'stock' => 'integer',
        ];
    }

    public function discountPercentage(): int
    {
        if ($this->mrp <= 0 || $this->sale_price >= $this->mrp) {
            return 0;
        }

        return (int) round((($this->mrp - $this->sale_price) / $this->mrp) * 100);
    }

    public function isLowStock(): bool
    {
        return $this->stock <= (int) Setting::get('low_stock_threshold', 5);
    }

    protected static function booted(): void
    {
        static::saving(function (Product $product) {
            if (empty($product->slug)) {
                $product->slug = Str::slug($product->name);
            }
        });
    }

    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class);
    }

    public function images(): HasMany
    {
        return $this->hasMany(ProductImage::class);
    }

    public function specifications(): HasMany
    {
        return $this->hasMany(ProductSpecification::class)->orderBy('sort_order');
    }

    public function relatedProducts(): BelongsToMany
    {
        return $this->belongsToMany(Product::class, 'product_related', 'product_id', 'related_product_id')
            ->withTimestamps();
    }

    public function stockMovements(): HasMany
    {
        return $this->hasMany(StockMovement::class)->latest();
    }

    public function reviews(): HasMany
    {
        return $this->hasMany(Review::class);
    }

    public function approvedReviews(): HasMany
    {
        return $this->hasMany(Review::class)->where('status', 'approved')->latest();
    }

    public function averageRating(): float
    {
        return (float) $this->approvedReviews()->avg('rating') ?: 0;
    }

    public function reviewsCount(): int
    {
        return $this->approvedReviews()->count();
    }
}
