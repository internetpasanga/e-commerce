<x-layouts.admin title="Dashboard">
    <h1 class="page-title">Dashboard</h1>

    <div class="dashboard-stats">
        <div class="stat-card">
            <span class="stat-card-icon">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><polyline points="23 6 13.5 15.5 8.5 10.5 1 18"/><polyline points="17 6 23 6 23 12"/></svg>
            </span>
            <div>
                <p class="stat-card-value">₹{{ number_format($revenueThisMonth, 2) }}</p>
                <p class="stat-card-label">Revenue this month</p>
            </div>
        </div>

        <div class="stat-card">
            <span class="stat-card-icon">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M6 2 3 6v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2V6l-3-4Z"/><path d="M3 6h18"/><path d="M16 10a4 4 0 0 1-8 0"/></svg>
            </span>
            <div>
                <p class="stat-card-value">{{ number_format($ordersThisMonth) }}</p>
                <p class="stat-card-label">Orders this month</p>
            </div>
        </div>

        <div class="stat-card">
            <span class="stat-card-icon">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"/><circle cx="9" cy="7" r="4"/><path d="M23 21v-2a4 4 0 0 0-3-3.87"/><path d="M16 3.13a4 4 0 0 1 0 7.75"/></svg>
            </span>
            <div>
                <p class="stat-card-value">{{ number_format($customerCount) }}</p>
                <p class="stat-card-label">Customers total</p>
            </div>
        </div>

        <div class="stat-card">
            <span class="stat-card-icon">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M21 8v13H3V8"/><path d="M1 3h22v5H1z"/><path d="M10 12h4"/></svg>
            </span>
            <div>
                <p class="stat-card-value">{{ number_format($activeProductCount) }}</p>
                <p class="stat-card-label">Active products</p>
            </div>
        </div>
    </div>

    <div class="card dashboard-chart-card">
        <h2 class="section-title">Revenue (Last 30 Days)</h2>

        @php $chartMax = max(1, collect($chartData)->max('total')); @endphp
        <div class="dashboard-chart">
            @foreach ($chartData as $day)
                <div class="dashboard-chart-bar" style="height: {{ $day['total'] > 0 ? max(2, round($day['total'] / $chartMax * 100)) : 1 }}%"
                     title="{{ $day['label'] }}: ₹{{ number_format($day['total'], 2) }}"></div>
            @endforeach
        </div>
    </div>

    <div class="dashboard-columns">
        <div class="card">
            <div class="dashboard-panel-header">
                <h2 class="section-title">Recent Orders</h2>
                <a href="{{ route('admin.orders.index') }}" class="btn-link">View all</a>
            </div>

            @if ($recentOrders->isEmpty())
                <p class="muted">No orders yet.</p>
            @else
                <div class="table-wrap">
                    <table>
                        <thead>
                            <tr>
                                <th>Order #</th>
                                <th>Customer</th>
                                <th>Total</th>
                                <th>Status</th>
                                <th>Date</th>
                                <th class="text-right">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($recentOrders as $order)
                                <tr>
                                    <td>{{ $order->order_number }}</td>
                                    <td>{{ $order->customer_name }}</td>
                                    <td>₹{{ number_format($order->grand_total, 2) }}</td>
                                    <td><span class="badge {{ \App\Models\Order::badgeClassForStatus($order->status) }}">{{ ucfirst($order->status) }}</span></td>
                                    <td>{{ $order->created_at->format('d M Y') }}</td>
                                    <td class="text-right">
                                        <a href="{{ route('admin.orders.show', $order) }}" class="btn-icon" title="View">
                                            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"/><circle cx="12" cy="12" r="3"/></svg>
                                        </a>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @endif
        </div>

        <div class="card">
            <div class="dashboard-panel-header">
                <h2 class="section-title">Low Stock Alerts</h2>
                <a href="{{ route('admin.inventory.index') }}" class="btn-link">View all</a>
            </div>

            @if ($lowStockProducts->isEmpty())
                <p class="muted">All products are well stocked.</p>
            @else
                <div class="low-stock-list">
                    @foreach ($lowStockProducts as $product)
                        <a href="{{ route('admin.inventory.show', $product) }}" class="low-stock-item">
                            <span class="low-stock-item-name">{{ $product->name }}</span>
                            <span class="badge {{ $product->stock <= 0 ? 'badge-danger' : 'badge-muted' }}">{{ $product->stock }} left</span>
                        </a>
                    @endforeach
                </div>
            @endif
        </div>
    </div>
</x-layouts.admin>
