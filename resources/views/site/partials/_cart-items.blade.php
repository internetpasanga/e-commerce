@if ($items->isNotEmpty())
    <div class="cart-table">
        @foreach ($items as $item)
            <div class="cart-row">
                @if ($item['product']->thumbnail)
                    <img src="{{ asset('storage/'.$item['product']->thumbnail) }}" alt="{{ $item['product']->name }}" class="cart-row-image">
                @else
                    <div class="cart-row-image"></div>
                @endif

                <div class="cart-row-info">
                    <a href="{{ route('product.show', $item['product']) }}" class="cart-row-name">{{ $item['product']->name }}</a>
                    <div class="price-row">
                        <p class="cart-row-price">₹{{ number_format($item['product']->sale_price, 2) }}</p>
                        @if ($item['product']->discountPercentage() > 0)
                            <p class="price-mrp">₹{{ number_format($item['product']->mrp, 2) }}</p>
                            <span class="badge badge-success">{{ $item['product']->discountPercentage() }}% OFF</span>
                        @endif
                    </div>
                </div>

                <div class="qty-stepper cart-row-qty">
                    <button type="button" class="qty-btn" data-action="cart-qty-decrease">&minus;</button>
                    <input type="text" class="qty-input" value="{{ $item['quantity'] }}" data-product-id="{{ $item['product']->id }}" inputmode="numeric" aria-label="Quantity">
                    <button type="button" class="qty-btn" data-action="cart-qty-increase">+</button>
                </div>

                <p class="cart-row-subtotal">₹{{ number_format($item['subtotal'], 2) }}</p>

                <button type="button" class="cart-row-remove" data-action="cart-remove" data-product-id="{{ $item['product']->id }}" title="Remove item">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M3 6h18"/><path d="M8 6V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2"/><path d="M19 6l-1 14a2 2 0 0 1-2 2H8a2 2 0 0 1-2-2L5 6"/></svg>
                </button>
            </div>
        @endforeach
    </div>

    @include('site.partials._order-summary', ['showCheckoutButton' => true])
@else
    <div class="empty-state">
        <span class="empty-state-icon">
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="9" cy="21" r="1"/><circle cx="20" cy="21" r="1"/><path d="M1 1h4l2.68 13.39a2 2 0 0 0 2 1.61h9.72a2 2 0 0 0 2-1.61L23 6H6"/></svg>
        </span>
        <p class="empty-state-title">Your cart is empty</p>
        <p class="empty-state-text">Looks like you haven't added anything to your cart yet.</p>
        <a href="{{ route('home') }}" class="btn btn-primary">Continue Shopping</a>
    </div>
@endif
