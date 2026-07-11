<div class="product-card">
    <a href="{{ route('product.show', $product) }}" class="product-card-link">
        <div class="product-card-image-wrap">
            @if ($product->thumbnail)
                <img src="{{ asset('storage/'.$product->thumbnail) }}" alt="{{ $product->name }}" class="product-card-image">
            @else
                <div class="product-card-image"></div>
            @endif

            @if ($product->stock > 0)
                <span class="stock-badge in-stock">In Stock</span>
            @else
                <span class="stock-badge out-of-stock">Out of Stock</span>
            @endif
        </div>
        <div class="product-card-body">
            @if ($product->relationLoaded('category') && $product->category)
                <p class="product-card-category">{{ $product->category->name }}</p>
            @endif
            <p class="product-card-name">{{ $product->name }}</p>
            <div class="price-row">
                <p class="product-card-price">₹{{ number_format($product->sale_price, 2) }}</p>
                @if ($product->discountPercentage() > 0)
                    <p class="price-mrp">₹{{ number_format($product->mrp, 2) }}</p>
                @endif
            </div>
            @if ($product->discountPercentage() > 0)
                <span class="badge badge-success">{{ $product->discountPercentage() }}% OFF</span>
            @endif
        </div>
    </a>

    <button type="button" class="wishlist-btn {{ \App\Support\Wishlist::has($product->id) ? 'active' : '' }}"
            data-action="toggle-wishlist" data-product-id="{{ $product->id }}" aria-label="Toggle wishlist">
        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M20.84 4.61a5.5 5.5 0 0 0-7.78 0L12 5.67l-1.06-1.06a5.5 5.5 0 0 0-7.78 7.78l1.06 1.06L12 21.23l7.78-7.78 1.06-1.06a5.5 5.5 0 0 0 0-7.78z"/></svg>
    </button>

    <div class="product-card-actions">
        <button type="button" class="btn btn-primary btn-sm add-to-cart-btn"
                data-product-id="{{ $product->id }}"
                data-product-name="{{ $product->name }}"
                {{ $product->stock <= 0 ? 'disabled' : '' }}>
            {{ $product->stock > 0 ? 'Add to Cart' : 'Out of Stock' }}
        </button>
    </div>
</div>
