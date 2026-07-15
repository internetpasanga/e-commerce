<div class="order-detail-layout">
    <div class="order-detail-main">
        <section class="card card-flush">
            <div class="card-header"><h2 class="card-title">Order Items</h2></div>
            <div class="table-wrap" style="box-shadow: none;">
                <table class="order-items-table">
                    <thead>
                        <tr>
                            <th>Product</th>
                            <th>Qty</th>
                            <th class="text-right">Price</th>
                            <th class="text-right">Subtotal</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($order->items as $item)
                            <tr>
                                <td class="order-item-name">{{ $item->product_name }}</td>
                                <td>{{ $item->quantity }}</td>
                                <td class="text-right">₹{{ number_format($item->sale_price, 2) }}</td>
                                <td class="text-right">₹{{ number_format($item->subtotal, 2) }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </section>

        <section class="card card-flush">
            <div class="card-header"><h2 class="card-title">Order Tracking</h2></div>
            <div class="card-body">
                <ol class="order-timeline">
                    @foreach ($order->statusHistories as $history)
                        @php
                            $tlColor = match ($history->status) {
                                'delivered' => 'var(--box-success)',
                                'processing', 'shipped' => 'var(--box-info)',
                                'cancelled' => 'var(--box-danger)',
                                default => 'var(--box-warning)',
                            };
                        @endphp
                        <li class="order-timeline-item {{ $loop->first ? 'is-current' : '' }}" style="--tl-color: {{ $tlColor }};">
                            <span class="order-timeline-marker">
                                @if ($history->status === 'cancelled')
                                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="3" stroke-linecap="round" stroke-linejoin="round"><path d="M18 6 6 18"/><path d="M6 6l12 12"/></svg>
                                @else
                                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="3" stroke-linecap="round" stroke-linejoin="round"><path d="M20 6 9 17l-5-5"/></svg>
                                @endif
                            </span>
                            <div class="order-timeline-content">
                                <div class="order-timeline-head">
                                    <span class="order-timeline-status">{{ ucfirst($history->status) }}</span>
                                    <span class="order-timeline-date">{{ $history->created_at->format('d M Y, h:i A') }}</span>
                                </div>
                                @if ($history->note)
                                    <p class="order-timeline-note">{{ $history->note }}</p>
                                @endif
                            </div>
                        </li>
                    @endforeach
                </ol>
            </div>
        </section>
    </div>

    <aside class="order-detail-side">
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

            @if ($order->coupon_code && $order->coupon_discount > 0)
                <div class="order-summary-row order-summary-savings">
                    <span>Coupon ({{ $order->coupon_code }})</span>
                    <span>&minus; ₹{{ number_format($order->coupon_discount, 2) }}</span>
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

        <section class="card card-flush">
            <div class="card-header"><h2 class="card-title">Delivery Address</h2></div>
            <div class="card-body">
                <p class="order-address">
                    <strong>{{ $order->shipping_name }}</strong><br>
                    {{ $order->shipping_phone }}<br>
                    {{ $order->shipping_address_line1 }}@if ($order->shipping_address_line2), {{ $order->shipping_address_line2 }}@endif<br>
                    {{ $order->shipping_city }}, {{ $order->shipping_state }} {{ $order->shipping_postal_code }}<br>
                    {{ $order->shipping_country }}
                </p>
            </div>
        </section>

        <section class="card card-flush">
            <div class="card-header"><h2 class="card-title">Billing Address</h2></div>
            <div class="card-body">
                <p class="order-address">
                    <strong>{{ $order->billing_name }}</strong><br>
                    {{ $order->billing_phone }}<br>
                    {{ $order->billing_address_line1 }}@if ($order->billing_address_line2), {{ $order->billing_address_line2 }}@endif<br>
                    {{ $order->billing_city }}, {{ $order->billing_state }} {{ $order->billing_postal_code }}<br>
                    {{ $order->billing_country }}
                </p>
            </div>
        </section>

        <section class="card card-flush">
            <div class="card-header"><h2 class="card-title">Payment</h2></div>
            <div class="card-body">
                <p class="order-payment-line">Method: <strong>{{ strtoupper($order->payment_method) }}</strong></p>
                <p class="order-payment-line">
                    Status:
                    <span class="badge {{ $order->payment_status === 'paid' ? 'badge-success' : 'badge-muted' }}">{{ ucfirst($order->payment_status) }}</span>
                </p>
            </div>
        </section>
    </aside>
</div>
