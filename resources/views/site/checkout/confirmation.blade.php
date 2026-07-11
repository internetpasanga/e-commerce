<x-layouts.site title="Order Confirmed">
    <div class="order-confirmation">
        <svg class="order-confirmation-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="10"/><path d="m9 12 2 2 4-4"/></svg>

        <h1 class="page-title">Thank you! Your order has been placed.</h1>
        <p>Order Number: <strong>{{ $order->order_number }}</strong></p>
        <p>A confirmation email has been sent to {{ $order->customer_email }}.</p>
    </div>

    @include('site.orders._order-detail')

    <div class="no-print" style="display: flex; gap: 0.75rem; margin-top: 1.5rem;">
        <button type="button" class="btn btn-secondary" onclick="window.print()">Print</button>
        <a href="{{ route('home') }}" class="btn btn-primary">Continue Shopping</a>
    </div>
</x-layouts.site>
