<x-layouts.site title="My Orders">
    @include('site.partials._account-header')

    @include('site.partials._account-nav')

    <div class="profile-tab-panel active">
        <section class="card">
            <h2 class="section-title">My Orders</h2>

            @if ($orders->isEmpty())
                <div class="cart-empty">
                    <p>You haven't placed any orders yet.</p>
                    <a href="{{ route('home') }}" class="btn btn-primary">Start Shopping</a>
                </div>
            @else
                <div class="table-wrap">
                    <table>
                        <thead>
                            <tr>
                                <th>Order #</th>
                                <th>Date</th>
                                <th>Items</th>
                                <th>Payment</th>
                                <th>Status</th>
                                <th>Total</th>
                                <th class="text-right">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($orders as $order)
                                <tr>
                                    <td>{{ $order->order_number }}</td>
                                    <td>{{ $order->created_at->format('d M Y') }}</td>
                                    <td>{{ $order->items_count }}</td>
                                    <td>
                                        @if ($order->payment_status === 'paid')
                                            <span class="badge badge-success">Paid</span>
                                        @else
                                            <span class="badge badge-muted">{{ ucfirst($order->payment_status) }}</span>
                                        @endif
                                    </td>
                                    <td><span class="badge badge-muted">{{ ucfirst($order->status) }}</span></td>
                                    <td>₹{{ number_format($order->grand_total, 2) }}</td>
                                    <td class="text-right">
                                        <a href="{{ route('orders.show', $order) }}" class="btn btn-secondary btn-sm">View</a>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

                <div style="margin-top: 1rem;">
                    {{ $orders->links() }}
                </div>
            @endif
        </section>
    </div>

    <script src="{{ asset('js/avatar-upload.js') }}"></script>
</x-layouts.site>
