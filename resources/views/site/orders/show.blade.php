<x-layouts.site title="Order {{ $order->order_number }}">
    <p class="breadcrumb"><a href="{{ route('orders.index') }}">My Orders</a> / {{ $order->order_number }}</p>

    <div class="order-head-card">
        <div>
            <h1>Order #{{ $order->order_number }}</h1>
            <p class="order-head-sub">Placed on {{ $order->created_at->format('d M Y, h:i A') }} &middot; {{ $order->items->sum('quantity') }} {{ Str::plural('item', $order->items->sum('quantity')) }} &middot; ₹{{ number_format($order->grand_total, 2) }}</p>
        </div>
        <div class="order-head-meta">
            <span class="badge order-badge-lg {{ \App\Models\Order::badgeClassForStatus($order->status) }}">{{ ucfirst($order->status) }}</span>
            @if ($order->status === 'delivered')
                <a href="{{ route('orders.invoice', $order) }}" class="btn btn-secondary btn-sm">Download Invoice</a>
            @else
                <span class="order-head-note">Invoice available once delivered</span>
            @endif
        </div>
    </div>

    @include('site.orders._order-detail')

    <p style="margin-top: 1.5rem;">
        <a href="{{ route('orders.index') }}" class="btn btn-outline btn-sm">&larr; Back to My Orders</a>
    </p>
</x-layouts.site>
