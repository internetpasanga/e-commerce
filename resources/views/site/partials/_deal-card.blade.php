@php
    [$dealWhole, $dealFrac] = explode('.', number_format($product->sale_price, 2, '.', ''));
@endphp
<a href="{{ route('product.show', $product) }}" class="deal-card">
    <div class="deal-card-image-wrap">
        @if ($product->thumbnail)
            <img src="{{ asset('storage/'.$product->thumbnail) }}" alt="{{ $product->name }}" class="deal-card-image">
        @else
            <div class="deal-card-image"></div>
        @endif
        @if ($product->discountPercentage() > 0)
            <span class="deal-card-badge">-{{ $product->discountPercentage() }}%</span>
        @endif
    </div>
    <div class="deal-card-body">
        <span class="deal-card-tag">Deal</span>
        <div class="pc-price">
            <span class="price">
                <span class="price-cur">₹</span><span class="price-whole">{{ number_format((int) $dealWhole) }}</span><span class="price-frac">{{ $dealFrac }}</span>
            </span>
        </div>
        <p class="deal-card-name">{{ $product->name }}</p>
    </div>
</a>
