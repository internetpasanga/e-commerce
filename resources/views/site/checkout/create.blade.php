<x-layouts.site title="Checkout">
    <h1 class="page-title">Checkout</h1>

    @if ($errors->any())
        <div class="alert alert-error">
            @foreach ($errors->all() as $error)
                <p>{{ $error }}</p>
            @endforeach
        </div>
    @endif

    <form method="POST" action="{{ route('checkout.store') }}">
        @csrf

        <div class="checkout-layout">
            <div class="checkout-main">
                <section class="card">
                    <h2 class="section-title">Shipping Address</h2>

                    <div class="address-option-list">
                        @foreach ($addresses as $address)
                            @include('site.partials._address-option', [
                                'address' => $address,
                                'groupName' => 'shipping_address_id',
                                'idPrefix' => 'shipping',
                                'checked' => $loop->first,
                            ])
                        @endforeach
                    </div>

                    <a href="{{ route('addresses.create', ['redirect' => 'checkout']) }}" class="link-add-address">+ Add a new address</a>
                </section>

                <section class="card">
                    <h2 class="section-title">Billing Address</h2>

                    <div class="form-group form-check">
                        <input type="checkbox" id="billing_same_as_shipping" name="billing_same_as_shipping" value="1" checked>
                        <label for="billing_same_as_shipping">Billing address same as shipping</label>
                    </div>

                    <div class="address-option-list" id="billing-address-list" style="display: none;">
                        @foreach ($addresses as $address)
                            @include('site.partials._address-option', [
                                'address' => $address,
                                'groupName' => 'billing_address_id',
                                'idPrefix' => 'billing',
                                'checked' => $loop->first,
                            ])
                        @endforeach
                    </div>
                </section>

                <section class="card">
                    <h2 class="section-title">Payment Method</h2>

                    <label class="payment-option">
                        <input type="radio" name="payment_method" value="cod" checked>
                        Cash on Delivery
                    </label>
                    @if ($razorpayEnabled)
                        <label class="payment-option">
                            <input type="radio" name="payment_method" value="razorpay">
                            Pay Online (Card / UPI / Netbanking via Razorpay)
                        </label>
                    @endif
                </section>
            </div>

            <div class="checkout-summary">
                @include('site.partials._order-summary', ['showCheckoutButton' => false])

                <button type="submit" class="btn btn-primary order-summary-checkout-btn">Place Order</button>
            </div>
        </div>
    </form>

    <script src="{{ asset('js/checkout.js') }}"></script>
    <script src="{{ asset('js/coupon.js') }}"></script>
</x-layouts.site>
