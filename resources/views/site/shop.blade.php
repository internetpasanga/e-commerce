<x-layouts.site title="Shop">
    <p class="breadcrumb"><a href="{{ route('home') }}">Home</a> / Shop</p>
    <h1 class="page-title">Shop</h1>

    <div class="product-grid">
        @forelse ($products as $product)
            @include('site.partials._product-card')
        @empty
            <p>No products available yet.</p>
        @endforelse
    </div>

    <div style="margin-top: 1.5rem;">
        {{ $products->links() }}
    </div>

    <script src="{{ asset('js/cart.js') }}"></script>
    <script src="{{ asset('js/wishlist.js') }}"></script>
</x-layouts.site>
