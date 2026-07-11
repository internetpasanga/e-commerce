<section class="card">
    <h2 class="section-title">Order Items</h2>
    <div class="table-wrap">
        <table>
            <thead>
                <tr>
                    <th>Product</th>
                    <th>Qty</th>
                    <th>Price</th>
                    <th>Subtotal</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($order->items as $item)
                    <tr>
                        <td>{{ $item->product_name }}</td>
                        <td>{{ $item->quantity }}</td>
                        <td>₹{{ number_format($item->sale_price, 2) }}</td>
                        <td>₹{{ number_format($item->subtotal, 2) }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</section>

<section class="card">
    <h2 class="section-title">Status History</h2>

    <ul class="status-timeline">
        @foreach ($order->statusHistories as $history)
            <li class="status-timeline-item">
                <div class="status-timeline-meta">
                    <span class="badge {{ \App\Models\Order::badgeClassForStatus($history->status) }}">{{ ucfirst($history->status) }}</span>
                    <span class="status-timeline-date">{{ $history->created_at->format('d M Y, h:i A') }}</span>
                </div>
                @if ($history->note)
                    <p class="status-timeline-note">{{ $history->note }}</p>
                @endif
            </li>
        @endforeach
    </ul>
</section>

<div class="checkout-layout">
    <section class="card">
        <h2 class="section-title">Shipping Address</h2>
        <p class="address-option-text">
            {{ $order->shipping_name }}<br>
            {{ $order->shipping_phone }}<br>
            {{ $order->shipping_address_line1 }}@if ($order->shipping_address_line2), {{ $order->shipping_address_line2 }}@endif<br>
            {{ $order->shipping_city }}, {{ $order->shipping_state }} {{ $order->shipping_postal_code }}<br>
            {{ $order->shipping_country }}
        </p>
    </section>

    <section class="card">
        <h2 class="section-title">Billing Address</h2>
        <p class="address-option-text">
            {{ $order->billing_name }}<br>
            {{ $order->billing_phone }}<br>
            {{ $order->billing_address_line1 }}@if ($order->billing_address_line2), {{ $order->billing_address_line2 }}@endif<br>
            {{ $order->billing_city }}, {{ $order->billing_state }} {{ $order->billing_postal_code }}<br>
            {{ $order->billing_country }}
        </p>
    </section>
</div>

<section class="card">
    <h2 class="section-title">Payment</h2>
    <p>Method: {{ strtoupper($order->payment_method) }}</p>
    <p>Status: {{ ucfirst($order->payment_status) }}</p>
</section>

<div class="order-summary">
    <h2 class="section-title">Order Summary</h2>

    <div class="order-summary-row">
        <span>Total MRP Price</span>
        <span>₹{{ number_format($order->total_mrp, 2) }}</span>
    </div>

    <div class="order-summary-row">
        <span>Total Discounted Price</span>
        <span>₹{{ number_format($order->subtotal, 2) }}</span>
    </div>

    @if ($order->total_discount > 0)
        <div class="order-summary-row order-summary-savings">
            <span>Total Save Amount</span>
            <span>&minus; ₹{{ number_format($order->total_discount, 2) }}</span>
        </div>
    @endif

    <div class="order-summary-row">
        <span>Shipping Charge</span>
        <span>
            @if ($order->shipping_charge > 0)
                ₹{{ number_format($order->shipping_charge, 2) }}
            @else
                <span class="badge badge-success">FREE</span>
            @endif
        </span>
    </div>

    <div class="order-summary-row order-summary-grand-total">
        <span>Total Amount</span>
        <span>₹{{ number_format($order->grand_total, 2) }}</span>
    </div>
</div>
