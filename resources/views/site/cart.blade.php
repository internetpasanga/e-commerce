<x-layouts.site title="Shopping Cart">
    <h1 class="page-title">Shopping Cart</h1>

    @if ($errors->any())
        <div class="alert alert-error">
            @foreach ($errors->all() as $error)
                <p>{{ $error }}</p>
            @endforeach
        </div>
    @endif

    <div id="cart-items">
        @include('site.partials._cart-items')
    </div>

    <script src="{{ asset('js/cart-page.js') }}"></script>
    <script src="{{ asset('js/coupon.js') }}"></script>
</x-layouts.site>
