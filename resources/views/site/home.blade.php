<x-layouts.site title="Home">
    @if ($banners->isNotEmpty())
        <div class="hero-slider" id="hero-slider">
            @foreach ($banners as $banner)
                <div class="hero-slide {{ $loop->first ? 'active' : '' }}">
                    <img src="{{ asset('storage/'.$banner->image) }}" alt="{{ $banner->title }}" class="hero-slide-image">
                    <div class="hero-slide-content position-{{ $banner->title_position }}">
                        <h2 class="hero-slide-title">{{ $banner->title }}</h2>
                        @if ($banner->sub_title)
                            <p class="hero-slide-subtitle">{{ $banner->sub_title }}</p>
                        @endif
                        @if ($banner->button_text && $banner->button_url)
                            <a href="{{ $banner->button_url }}" class="hero-slide-btn"
                               style="background-color: {{ $banner->button_color ?? '#4f46e5' }};">
                                {{ $banner->button_text }}
                            </a>
                        @endif
                    </div>
                </div>
            @endforeach

            @if ($banners->count() > 1)
                <button type="button" class="hero-slider-nav prev" data-action="prev-slide" aria-label="Previous slide">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M15 18l-6-6 6-6"/></svg>
                </button>
                <button type="button" class="hero-slider-nav next" data-action="next-slide" aria-label="Next slide">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M9 18l6-6-6-6"/></svg>
                </button>
                <div class="hero-slider-dots">
                    @foreach ($banners as $banner)
                        <button type="button" class="hero-slider-dot {{ $loop->first ? 'active' : '' }}" data-index="{{ $loop->index }}" aria-label="Go to slide {{ $loop->iteration }}"></button>
                    @endforeach
                </div>
            @endif
        </div>
    @endif

    <section class="trust-bar">
        <div class="trust-item">
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><rect x="1" y="3" width="15" height="13"/><path d="M16 8h4l3 3v5h-7V8z"/><circle cx="5.5" cy="18.5" r="2.5"/><circle cx="18.5" cy="18.5" r="2.5"/></svg>
            <div>
                <p class="trust-item-title">Fast Delivery</p>
                <p class="trust-item-text">Quick order dispatch</p>
            </div>
        </div>
        <div class="trust-item">
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M21 12a9 9 0 1 1-6.219-8.56"/><path d="M12 3v9l4 2"/></svg>
            <div>
                <p class="trust-item-title">Easy Returns</p>
                <p class="trust-item-text">Hassle-free exchange</p>
            </div>
        </div>
        <div class="trust-item">
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z"/></svg>
            <div>
                <p class="trust-item-title">Secure Payment</p>
                <p class="trust-item-text">100% protected checkout</p>
            </div>
        </div>
        <div class="trust-item">
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M21 15a2 2 0 0 1-2 2H7l-4 4V5a2 2 0 0 1 2-2h14a2 2 0 0 1 2 2z"/></svg>
            <div>
                <p class="trust-item-title">Dedicated Support</p>
                <p class="trust-item-text">We're here to help</p>
            </div>
        </div>
    </section>

    <section class="home-section">
        <h2 class="page-title">Shop by Category</h2>

        <div class="category-grid">
            @forelse ($categories as $category)
                <a href="{{ route('category.show', $category) }}" class="category-tile">
                    @if ($category->image)
                        <img src="{{ asset('storage/'.$category->image) }}" alt="{{ $category->name }}">
                    @endif
                    <span class="category-tile-overlay">
                        <span class="category-name">{{ $category->name }}</span>
                    </span>
                </a>
            @empty
                <p>No categories available yet.</p>
            @endforelse
        </div>
    </section>

    <section class="home-section">
        <h2 class="page-title">Featured Products</h2>

        <div class="product-grid">
            @forelse ($products as $product)
                @include('site.partials._product-card')
            @empty
                <p>No products available yet.</p>
            @endforelse
        </div>
    </section>

    @if ($banners->count() > 1)
        <script src="{{ asset('js/hero-slider.js') }}"></script>
    @endif
    <script src="{{ asset('js/cart.js') }}"></script>
    <script src="{{ asset('js/wishlist.js') }}"></script>
</x-layouts.site>
