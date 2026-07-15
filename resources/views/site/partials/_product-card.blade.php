<div class="product-card">
    <a href="{{ route('product.show', $product) }}" class="product-card-link">
        <div class="product-card-image-wrap">
            @if ($product->thumbnail)
                <img src="{{ asset('storage/'.$product->thumbnail) }}" alt="{{ $product->name }}" class="product-card-image">
            @else
                <div class="product-card-image"></div>
            @endif

            @if ($product->stock <= 0)
                <span class="stock-badge out-of-stock">Out of Stock</span>
            @endif
        </div>
        <div class="product-card-body">
            @if ($product->relationLoaded('category') && $product->category)
                <p class="product-card-category">{{ $product->category->name }}</p>
            @endif
            <p class="product-card-name">{{ $product->name }}</p>

            @php
                // Prefer eager-loaded aggregates when the controller provides them
                // (withCount/withAvg on approvedReviews); fall back to the model helpers.
                $ratingCount = $product->approved_reviews_count ?? $product->reviewsCount();
                $ratingAvg = $ratingCount > 0
                    ? (float) ($product->approved_reviews_avg_rating ?? $product->averageRating())
                    : 0.0;
            @endphp
            @if ($ratingCount > 0)
                @include('site.partials._stars', ['rating' => $ratingAvg, 'count' => $ratingCount])
            @endif

            @php
                [$priceWhole, $priceFrac] = explode('.', number_format($product->sale_price, 2, '.', ''));
            @endphp
            <div class="pc-price">
                <span class="price">
                    <span class="price-cur">₹</span><span class="price-whole">{{ number_format((int) $priceWhole) }}</span><span class="price-frac">{{ $priceFrac }}</span>
                </span>
                @if ($product->discountPercentage() > 0)
                    <span class="price-off">{{ $product->discountPercentage() }}% off</span>
                @endif
            </div>
            @if ($product->discountPercentage() > 0)
                <div class="price-list">M.R.P: <span class="strike">₹{{ number_format($product->mrp, 2) }}</span></div>
            @endif
        </div>
    </a>

    @php $inWishlist = \App\Support\Wishlist::has($product->id); @endphp
    <button type="button" class="wishlist-btn {{ $inWishlist ? 'active' : '' }}"
            data-action="toggle-wishlist" data-product-id="{{ $product->id }}"
            aria-pressed="{{ $inWishlist ? 'true' : 'false' }}"
            aria-label="{{ $inWishlist ? 'Remove from wishlist' : 'Add to wishlist' }}">
        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M20.84 4.61a5.5 5.5 0 0 0-7.78 0L12 5.67l-1.06-1.06a5.5 5.5 0 0 0-7.78 7.78l1.06 1.06L12 21.23l7.78-7.78 1.06-1.06a5.5 5.5 0 0 0 0-7.78z"/></svg>
    </button>

    <div class="product-card-actions">
        <button type="button" class="btn btn-primary btn-sm add-to-cart-btn"
                data-product-id="{{ $product->id }}"
                data-product-name="{{ $product->name }}"
                {{ $product->stock <= 0 ? 'disabled' : '' }}>
            @if ($product->stock > 0)
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="9" cy="21" r="1"/><circle cx="20" cy="21" r="1"/><path d="M1 1h4l2.68 13.39a2 2 0 0 0 2 1.61h9.72a2 2 0 0 0 2-1.61L23 6H6"/></svg>
            @endif
            {{ $product->stock > 0 ? 'Add to Cart' : 'Out of Stock' }}
        </button>
    </div>
</div>
