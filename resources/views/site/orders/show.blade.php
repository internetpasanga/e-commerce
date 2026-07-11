<x-layouts.site title="Order {{ $order->order_number }}">
    <div class="page-header">
        <div>
            <h1 class="page-title" style="margin-bottom: 0.35rem;">Order {{ $order->order_number }}</h1>
            <p style="color: var(--text-muted); margin: 0;">Placed on {{ $order->created_at->format('d M Y, h:i A') }}</p>
        </div>
        <div style="display: flex; align-items: center; gap: 0.75rem;">
            <span class="badge {{ \App\Models\Order::badgeClassForStatus($order->status) }}">{{ ucfirst($order->status) }}</span>
            @if ($order->status === 'delivered')
                <a href="{{ route('orders.invoice', $order) }}" class="btn btn-secondary btn-sm">Download Invoice</a>
            @else
                <span class="muted" style="font-size: 0.8125rem; color: var(--text-muted);">Invoice available once delivered</span>
            @endif
        </div>
    </div>

    @include('site.orders._order-detail')

    <p style="margin-top: 1.5rem;">
        <a href="{{ route('orders.index') }}">&larr; Back to My Orders</a>
    </p>
</x-layouts.site>
