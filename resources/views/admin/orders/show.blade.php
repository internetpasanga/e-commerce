<x-layouts.admin title="Order {{ $order->order_number }}">
    <div class="page-header">
        <div>
            <h1 class="page-title" style="margin-bottom: 0.35rem;">Order {{ $order->order_number }}</h1>
            <p style="color: var(--text-muted); margin: 0;">Placed on {{ $order->created_at->format('d M Y, h:i A') }} by {{ $order->customer_name }}</p>
        </div>
        <div style="display: flex; align-items: center; gap: 0.75rem;">
            <span class="badge {{ \App\Models\Order::badgeClassForStatus($order->status) }}">{{ ucfirst($order->status) }}</span>
            <button type="button" class="btn btn-secondary btn-sm no-print" onclick="window.print()">Print</button>
            <a href="{{ route('admin.orders.invoice', $order) }}" class="btn btn-secondary btn-sm no-print">Download Invoice</a>
        </div>
    </div>

    @if (session('status'))
        <div class="alert alert-success">
            <p>{{ session('status') }}</p>
        </div>
    @endif

    @if ($errors->any())
        <div class="alert alert-error">
            @foreach ($errors->all() as $error)
                <p>{{ $error }}</p>
            @endforeach
        </div>
    @endif

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
        <p>Status: <span class="badge {{ $order->payment_status === 'paid' ? 'badge-success' : 'badge-muted' }}">{{ ucfirst($order->payment_status) }}</span></p>
        @if ($order->razorpay_payment_id)
            <p>Razorpay Payment ID: {{ $order->razorpay_payment_id }}</p>
        @endif

        @if ($order->payment_method === 'cod')
            <form method="POST" action="{{ route('admin.orders.payment-status.update', $order) }}" class="no-print" style="margin-top: 1rem;">
                @csrf
                @method('PUT')

                <div class="form-group">
                    <label for="payment_status" class="form-label">Update Payment Status</label>
                    <select id="payment_status" name="payment_status" class="form-control">
                        @foreach (\App\Models\Order::PAYMENT_STATUSES as $paymentStatus)
                            <option value="{{ $paymentStatus }}" @selected(old('payment_status', $order->payment_status) === $paymentStatus)>{{ ucfirst($paymentStatus) }}</option>
                        @endforeach
                    </select>
                    <small style="color: var(--text-muted);">Cash on Delivery orders aren't marked paid automatically &mdash; update this once the payment is collected.</small>
                </div>

                <button type="submit" class="btn btn-secondary">Update Payment Status</button>
            </form>
        @endif
    </section>

    <div class="checkout-layout">
        <section class="card no-print">
            <h2 class="section-title">Update Status</h2>

            <form method="POST" action="{{ route('admin.orders.status.update', $order) }}">
                @csrf
                @method('PUT')

                <div class="form-group">
                    <label for="status" class="form-label">Status</label>
                    <select id="status" name="status" class="form-control">
                        @foreach (\App\Models\Order::STATUSES as $status)
                            <option value="{{ $status }}" @selected(old('status', $order->status) === $status)>{{ ucfirst($status) }}</option>
                        @endforeach
                    </select>
                    @if ($order->status !== 'cancelled')
                        <small style="color: var(--text-muted);">Choosing "Cancelled" will restock the ordered items.</small>
                    @endif
                </div>

                <div class="form-group">
                    <label for="note" class="form-label">Note (optional)</label>
                    <textarea id="note" name="note" rows="2" class="form-control" placeholder="e.g. Shipped via BlueDart, tracking #123456"></textarea>
                    @error('note') <span class="field-error">{{ $message }}</span> @enderror
                </div>

                <button type="submit" class="btn btn-primary">Update Status</button>
            </form>
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
                        @if ($history->changedBy)
                            <p class="status-timeline-note">by {{ $history->changedBy->name }}</p>
                        @endif
                    </li>
                @endforeach
            </ul>
        </section>
    </div>

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

    <p class="no-print" style="margin-top: 1.5rem;">
        <a href="{{ route('admin.orders.index') }}">&larr; Back to Orders</a>
    </p>
</x-layouts.admin>
