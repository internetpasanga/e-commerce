<div class="order-summary">
    <h2 class="section-title">Order Summary</h2>

    <div class="order-summary-row">
        <span>Total MRP Price</span>
        <span>₹{{ number_format($totalMrp, 2) }}</span>
    </div>

    <div class="order-summary-row">
        <span>Total Discounted Price</span>
        <span>₹{{ number_format($total, 2) }}</span>
    </div>

    @if ($savings > 0)
        <div class="order-summary-row order-summary-savings">
            <span>Total Save Amount</span>
            <span>&minus; ₹{{ number_format($savings, 2) }}</span>
        </div>
    @endif

    @if ($couponCode ?? null)
        <div class="order-summary-row order-summary-savings">
            <span>Coupon ({{ $couponCode }})</span>
            <span>
                &minus; ₹{{ number_format($couponDiscount, 2) }}
                <button type="button" class="link-remove-coupon" data-action="remove-coupon">Remove</button>
            </span>
        </div>
    @else
        <div class="coupon-apply-box">
            <input type="text" id="coupon-code-input" class="form-control" placeholder="Have a coupon code?">
            <button type="button" class="btn btn-secondary" data-action="apply-coupon">Apply</button>
        </div>
        <p class="coupon-error" id="coupon-error" style="display: none;"></p>
    @endif

    @if ($shippingCharge !== null)
        <div class="order-summary-row">
            <span>Shipping Charge</span>
            <span>
                @if ($shippingCharge > 0)
                    ₹{{ number_format($shippingCharge, 2) }}
                @else
                    <span class="badge badge-success">FREE</span>
                @endif
            </span>
        </div>
    @endif

    <div class="order-summary-row order-summary-grand-total">
        <span>Total Amount</span>
        <span>₹{{ number_format($grandTotal, 2) }}</span>
    </div>

    @if ($showCheckoutButton ?? false)
        <a href="{{ route('checkout.create') }}" class="btn btn-primary order-summary-checkout-btn">Proceed to Checkout</a>
    @endif
</div>
